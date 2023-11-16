<?php

namespace Gepopp\Image\Model;

use Gepopp\Image\Casts\FilenameCast;
use Gepopp\Image\ImageFilenameCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Image extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'filename',
        'path',
        'webp_path',
        'url',
        'webp_url',
        'mime',
        'width',
        'height',
        'size',
        'sizes',
        'webp_sizes',
        'srcset',
        'webp_srcset',
        'meta',
    ];


    protected $casts = [
        'filename'   => FilenameCast::class,
        'width'      => 'integer',
        'height'     => 'integer',
        'size'       => 'integer',
        'sizes'      => 'array',
        'webp_sizes' => 'array',
        'meta'       => 'array',
    ];


    public function path(): Attribute
    {
        return Attribute::make(
            get: fn( $value ) => is_null( $value ) ? \Gepopp\Image\Image::slashedImageFolder() . $this->filename : $value,
        );
    }


    public function alt(): Attribute
    {
        return Attribute::make(
            get: fn( $value ) => is_null( $value ) && config( 'image.use_filename_for_empty_alt' ) ?
                Str::headline( $this->filename?->filename ) :
                $value
        );
    }

    public function __toString()
    {
        return $this->path;
    }
}
