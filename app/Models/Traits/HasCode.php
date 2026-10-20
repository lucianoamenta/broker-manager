<?php

namespace App\Models\Traits;

use Illuminate\Support\Collection;

trait HasCode
{
    /**
     * Busca un modelo por un valor de código (normalizado a minúsculas).
     *
     * @param  string  $code  Valor del código a buscar (ej: 'FOTO_DNI_FRENTE', 'Foto_Dni_Frente')
     * @param  string  $column  Nombre de la columna en la BD (por defecto: 'code')
     * @return static|null
     *
     * Ejemplo:
     *   KycType::findByCode('FOTO_DNI_FRENTE'); // encuentra 'foto_dni_frente' en BD
     *   CurrencyType::findByCode('Usd', 'code'); // encuentra 'USD' si en BD está como 'usd' o 'USD'
     */
    public static function findByCode(string $code, string $column = 'code'): ?self
    {
        $normalizedCode = strtolower(trim($code));

        return self::whereRaw("LOWER({$column}) = ?", [$normalizedCode])
            ->first();
    }

    /**
     * Busca un modelo por un valor de nombre (normalizado a minúsculas).
     *
     * @param  string  $name  Valor del nombre a buscar (ej: 'Masculino', 'MASCULINO')
     * @param  string  $column  Nombre de la columna en la BD (por defecto: 'name')
     * @return static|null
     *
     * Ejemplo:
     *   KycType::findByName('masculino'); // encuentra 'Masculino' en BD
     *   CurrencyType::findByName('dolar estadounidense', 'name'); // encuentra 'Dólar estadounidense' si en BD está como 'dolar estadounidense' o 'Dólar estadounidense'
     */
    public static function findByName(string $name, string $column = 'name'): ?self
    {
        $normalizedName = strtolower(trim($name));

        return self::whereRaw("LOWER({$column}) = ?", [$normalizedName])
            ->first();
    }

    /**
     * Verifica si existe un modelo con el código dado (normalizado a minúsculas).
     *
     * @param  string  $code  Valor del código a verificar
     * @param  string  $column  Nombre de la columna en la BD
     */
    public static function isValidCode(string $code, string $column = 'code'): bool
    {
        $normalizedCode = strtolower(trim($code));

        return self::whereRaw("LOWER({$column}) = ?", [$normalizedCode])
            ->exists();
    }

    /**
     * Verifica si existe un modelo con el nombre dado (normalizado a minúsculas).
     *
     * @param  string  $name  Valor del nombre a verificar
     * @param  string  $column  Nombre de la columna en la BD
     */
    public static function isValidName(string $name, string $column = 'name'): bool
    {
        $normalizedName = strtolower(trim($name));

        return self::whereRaw("LOWER({$column}) = ?", [$normalizedName])
            ->exists();
    }

    /**
     * [Opcional] Obtiene todos los códigos existentes (útil para APIs de referencia).
     *
     * @return Collection<string>
     */
    public static function getAllCodes(string $column = 'code'): Collection
    {
        return self::pluck($column)->map(fn ($v) => strtolower($v))->unique();
    }
}
