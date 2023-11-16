<?php

namespace Gepopp\Image\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Gepopp\Image\Filenames\Filename;

class FilenameCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get( Model $model, string $key, mixed $value, array $attributes ): mixed
    {
        return is_null( $value ) ? $value : new Filename( $value );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set( Model $model, string $key, mixed $value, array $attributes ): mixed
    {
        return (string) $value;
    }
}
