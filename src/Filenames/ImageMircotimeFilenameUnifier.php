<?php

namespace Gepopp\Image\Filenames;

use Illuminate\Support\Str;

class ImageMircotimeFilenameUnifier implements FilenameUnifierInterface
{

    public static function getFilenameUnifier( Filename $filename ): string
    {
        return Str::remove(['.', ' '], microtime());
    }
}
