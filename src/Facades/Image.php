<?php

namespace Gepopp\Image\Facades;

use Illuminate\Support\Facades\Facade;

class Image extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'image';
    }
}
