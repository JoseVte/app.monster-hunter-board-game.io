<?php

namespace Database\Seeders;

use InvalidArgumentException;

/**
 * The seed data used to live under `config/`, which meant every request in
 * production loaded and unserialised 221 kB of weapons and monsters to serve
 * seven calls that only ever run from the console. It is read from disk here
 * instead, once per file per process.
 */
class SeedData
{
    /** @var array<string, array<mixed>> */
    private static array $files = [];

    /**
     * `armors.HEAD` reads the HEAD key out of armors.php, `weapons/bow` reads
     * the whole of weapons/bow.php.
     *
     * @return array<mixed>
     */
    public static function get(string $path): array
    {
        [$file, $key] = array_pad(explode('.', $path, 2), 2, null);

        $data = self::$files[$file] ??= self::read($file);

        if ($key === null) {
            return $data;
        }

        return $data[$key] ?? [];
    }

    /**
     * @return array<mixed>
     */
    private static function read(string $file): array
    {
        $path = database_path("seeders/data/$file.php");

        if (! is_file($path)) {
            throw new InvalidArgumentException("No seed data file at [$path].");
        }

        return require $path;
    }
}
