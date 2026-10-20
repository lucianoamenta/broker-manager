<?php

namespace App\Services\Storage;

use App\Services\Storage\Exceptions\S3UploadException;
use App\Services\Storage\ValueObjects\StoredFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3Service
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = 's3';
    }

    /**
     * Sube la imagen de perfil del usuario.
     */
    public function uploadUserProfileImage(UploadedFile $file, string $userUuid): StoredFile
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->timestamp;
        $filename = "profile-{$timestamp}.{$extension}";
        $directory = "users/{$userUuid}/profile";

        return $this->upload($file, $directory, $filename, 'public');
    }

    /**
     * Sube un archivo a S3 a partir de un string Base64 (Data URI o Base64 raw).
     */
    public function uploadFromBase64(
        string $base64File,
        string $directory,
        ?string $filename = null,
        string $visibility = 'public'
    ): StoredFile {
        try {
            $parsed = $this->parseBase64File($base64File);
            $extension = $parsed['extension'];
            $content = $parsed['content'];
            $mimeType = $parsed['mimeType'];

            if (! $filename) {
                $timestamp = now()->timestamp;
                $filename = "file-{$timestamp}.{$extension}";
            } elseif (! str_contains($filename, '.')) {
                $filename = "{$filename}.{$extension}";
            }

            $path = trim($directory, '/').'/'.$filename;

            Storage::disk($this->disk)->put(
                $path,
                $content,
                $visibility
            );

            return new StoredFile(
                disk: $this->disk,
                path: $path,
                url: Storage::disk($this->disk)->url($path),
                mime: $mimeType,
                size: strlen($content),
            );
        } catch (\Throwable $e) {
            throw new S3UploadException(
                'Error uploading base64 file to S3: '.$e->getMessage(),
                previous: $e
            );
        }
    }

    /**
     * Parsea un string Base64 y extrae su contenido binario, extensión y MIME type.
     */
    public function parseBase64File(string $base64File, string $defaultMimeType = 'image/jpeg'): array
    {
        if (preg_match('/^data:(\w+\/[\w-]+);base64,/', $base64File, $matches)) {
            $mimeType = $matches[1];
            $fileData = substr($base64File, strpos($base64File, ',') + 1);
            $fileContent = base64_decode($fileData);
        } else {
            $fileContent = base64_decode($base64File, true);
            $mimeType = $defaultMimeType;
        }

        if ($fileContent === false) {
            throw new \InvalidArgumentException('Formato de archivo inválido o error al decodificar Base64.');
        }

        $extension = 'jpg';
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/webp':
                $extension = 'webp';
                break;
            case 'application/pdf':
                $extension = 'pdf';
                break;
        }

        return [
            'content' => $fileContent,
            'extension' => $extension,
            'mimeType' => $mimeType,
        ];
    }

    /**
     * Sube un archivo a S3.
     *
     * @param  UploadedFile|string  $file  UploadedFile (HTTP) o path local
     * @param  string  $directory  Directorio dentro del bucket
     * @param  string|null  $filename  Nombre final del archivo
     * @param  string  $visibility  private | public
     */
    public function upload(
        UploadedFile|string $file,
        string $directory,
        ?string $filename = null,
        string $visibility = 'private'
    ): StoredFile {
        try {
            if ($file instanceof UploadedFile) {
                $filename ??= $file->getClientOriginalName();

                Storage::disk($this->disk)->putFileAs(
                    $directory,
                    $file,
                    $filename,
                    $visibility
                );
            } else {
                if (! file_exists($file)) {
                    throw new \RuntimeException("File not found: {$file}");
                }

                $filename ??= basename($file);
                $path = trim($directory, '/').'/'.$filename;

                Storage::disk($this->disk)->put(
                    $path,
                    fopen($file, 'r'),
                    $visibility
                );
            }

            $path = trim($directory, '/').'/'.$filename;

            return new StoredFile(
                disk: $this->disk,
                path: $path,
                url: Storage::disk($this->disk)->url($path),
                mime: Storage::disk($this->disk)->mimeType($path),
                size: Storage::disk($this->disk)->size($path),
            );
        } catch (\Throwable $e) {
            throw new S3UploadException(
                'Error uploading file to S3',
                previous: $e
            );
        }
    }
}
