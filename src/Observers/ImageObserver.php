<?php

namespace Gepopp\Image\Observers;


use Gepopp\Image\Jobs\CreateImageSizeJob;
use Gepopp\Image\Jobs\ImageCreateWebpJob;
use Gepopp\Image\Model\Image;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;

class ImageObserver
{
    /**
     * Handle the Image "created" event.
     */
    public function created( Image $image ): void
    {
        $contents     = Storage::get( $image );
        $intervention = Intervention::make( $contents );

        $image->updateQuietly( [
            'path'   => (string) $image,
            'url'    => Storage::url( $image ),
            'mime'   => Storage::mimeType( $image ),
            'size'   => Storage::size( $image ),
            'width'  => $intervention->getWidth(),
            'height' => $intervention->getHeight(),
        ] );


        if(config('image.create_webps')){

            if(config('image.queue_webp_creation'))
            {
                ImageCreateWebpJob::dispatch($image->id);
            }else{
                ImageCreateWebpJob::dispatchSync($image->id);
            }

        }


        if( config('image.image_sizes.create') )
        {
            $sizes = Arr::sortDesc( config('image.image_sizes.sizes'));
            foreach ($sizes as $size)
            {
                if( config('image.image_sizes.queue')){
                    CreateImageSizeJob::dispatch($image->id, ...$size);
                }else{
                    CreateImageSizeJob::dispatchSync($image->id, ...$size);
                }
            }
        }
    }


    /**
     * Handle the Image "force deleted" event.
     */
    public function forceDeleted( Image $image ): void
    {
        if(!is_null($image->path) && Storage::exists($image->path))
        {
            Storage::delete($image->path);
        }

        if(!is_null($image->webp_path) && Storage::exists($image->webp_path))
        {
            Storage::delete($image->webp_path);
        }

        foreach ( $image->sizes ?? [] as $size ) {
            if(Storage::exists($size))
            {
                Storage::delete($size);
            }
        }

        foreach ( $image->webp_sizes ?? [] as $size ) {
            if(Storage::exists($size))
            {
                Storage::delete($size);
            }
        }

    }
}
