<?php

namespace Gepopp\Image;

use Illuminate\Support\Facades\Storage;
use Gepopp\Image\Model\Image;
use Intervention\Image\Facades\Image as Intervention;

class ImageData
{

    public \Intervention\Image\Image $intervention;


    public function __construct( public Image $image )
    {


    }


    public function getUrl()
    {
        return Storage::url( $this->image->path );
    }


}
