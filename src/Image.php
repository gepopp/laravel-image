<?php

namespace Gepopp\Image;

use Gepopp\Image\Filenames\Filename;
use Gepopp\Image\Filenames\FilenameUnifierInterface;
use Illuminate\Support\Str;

class Image
{
    public static function getMaybeUnifiedFilename( Filename|string $filename ): string
    {
        $filename = is_string( $filename ) ? new Filename( $filename ) : $filename;

        if( config('image.filenames.unify') ){
            $unifierClass = config( 'image.filenames.unifiy_with' );
            return $filename->addUnifierToFilename( $unifierClass::getFilenameUnifier( $filename ));
        }

        return (string) $filename;
    }


    public static function slashedImageFolder()
    {
        return Str::of( config( 'image.folder' ) )->finish( '/' );
    }
}
