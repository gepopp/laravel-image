<?php

namespace Gepopp\Image\Filenames;

use Gepopp\Image\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCounterFilenameUnifier implements FilenameUnifierInterface
{

    public static function getFilenameUnifier( Filename $filename ): string
    {
        if(!Storage::exists( Image::slashedImageFolder() . $filename ))
        {
            return '';
        }

        $counter = 1;
        while ( Storage::exists( Image::slashedImageFolder() . $filename->addUnifierToFilename( $counter ) ) ) {
            $counter ++;
        }

        return (string) $counter;
    }
}
