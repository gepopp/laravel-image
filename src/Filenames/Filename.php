<?php

namespace Gepopp\Image\Filenames;

use Gepopp\Image\Image;
use Illuminate\Support\Str;

class Filename
{

    public string $filename;


    public string $extension;


    public string $seperator;



    public function __construct( public string $originalFilename )
    {
        $this->filename  = pathinfo( $this->originalFilename, PATHINFO_FILENAME );
        $this->extension = pathinfo( $this->originalFilename, PATHINFO_EXTENSION );
        $this->seperator = config( 'image.filenames.slugify_with' );
    }


    public function addUnifierToFilename( string $unifier ): string
    {
        if ( config( 'image.filenames.unify_at' ) == 'start' ) {
            $filename = $this->seperate( $unifier ) . $this->getMaybeSlugifiedFilename( false );
        } else {
            $filename = $this->seperate( $this->getMaybeSlugifiedFilename()) . $unifier;
        }

        $filename = trim( $filename, $this->seperator );

        return $filename . '.' . $this->extension;
    }


    public function getMaybeSlugifiedFilename( bool $withExtension = false ): string
    {
        if ( ! config( 'image.filenames.slugify_filenames' ) ) {
            return $withExtension ? $this->filename . '.' . $this->extension : $this->filename;
        }

        $slugified = Str::slug( $this->filename, config( 'image.filenames.slugify_with' ) );

        return $withExtension ? $slugified . '.' . $this->extension : $slugified;
    }


    public function seperate( string $property ): string
    {
        return property_exists( $this, $property ) ? $this->$property . $this->seperator : $property . $this->seperator;
    }




    public function __toString(): string
    {
        return $this->getMaybeSlugifiedFilename( true );
    }

}
