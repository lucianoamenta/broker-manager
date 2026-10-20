<?php

namespace App\Services\Storage\ValueObjects;

class StoredFile
{
    public function __construct(
        public readonly string $disk,
        public readonly string $path,
        public readonly string $url,
        public readonly string $mime,
        public readonly int $size,
    ) {}
}
