<?php

namespace Gepopp\Image\Jobs;

use Gepopp\Image\Filenames\Filename;
use Gepopp\Image\Model\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;
use Gepopp\Image\Image as GImage;

class CreateImageSizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public Image $image;

    /**
     * Create a new job instance.
     */
    public function __construct( public int $image_id, public int $width, public int|null $height, public bool $crop = false, public bool $webp = true )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->image = Image::find( $this->image_id );
        $intervention = Intervention::make( Storage::get( $this->image->path ) );

        if ( $this->width > $intervention->getWidth() ) {
            return;
        }

        if ( ! $this->crop ) {
            $intervention->resize( $this->width, $this->height, function ( $constraint ) {
                $constraint->aspectRatio();
            } );
        } else {
            $intervention->fit( $this->width, $this->height );
        }

        $height        = $this->height ?? $intervention->getHeight();
        $size_filename = GImage::slashedImageFolder() . "{$this->image->filename->seperate('filename')}{$this->width}x{$height}.{$this->image->filename->extension}";
        $size_url = $this->saveFileAndGetUrl( $size_filename, $intervention->stream());

        $this->image->sizes = $this->addToSizes( $this->image->sizes, $size_filename, $this->width, $height );
        $this->image->srcset = $this->addToSrcset( $this->image->srcset, $size_url, $this->width );


        if ( config( 'image.image_sizes.create_webp' ) ) {
            $this->createSizeWebp( $intervention, $height );
        }

        $this->image->saveQuietly();
    }


    public function addToSizes( array|null $sizes, $path, $width, $height ): array
    {
        $sizes = $sizes ?? [];
        $sizes[ $width . 'x' . $height ] = $path;

        return $sizes;
    }



    protected function addToSrcset( string|null $srcset, string $url, int $width ): string
    {
        $srcset = $srcset ?? '';
        $srcset .= ", $url {$width}w, ";
        return trim( $srcset, ', ');;
    }


    public function saveFileAndGetUrl( string $path, mixed $contents ): string
    {
        Storage::put($path, $contents);
        return Storage::url($path);
    }



    /**
     * @param \Intervention\Image\Image $intervention
     * @param int $height
     *
     * @return void
     */
    public function createSizeWebp( \Intervention\Image\Image $intervention, int $height ): void
    {
        $intervention->encode( 'webp' );

        $webp_filename = GImage::slashedImageFolder() . "{$this->image->filename->seperate('filename')}{$this->width}x{$height}.webp";
        $webp_url = $this->saveFileAndGetUrl( $webp_filename, $intervention->stream());

        $this->image->webp_sizes  = $this->addToSizes( $this->image->webp_sizes, $webp_filename, $this->width, $height );
        $this->image->webp_srcset = $this->addToSrcset( $this->image->webp_srcset, $webp_url, $this->width );
    }
}
