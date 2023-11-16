<?php

namespace Gepopp\Image\Jobs;

use Gepopp\Image\Model\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Gepopp\Image\Image as GImage;

class ImageCreateWebpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct( public int $image_id )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $image = Image::find($this->image_id);
        $intervention = \Intervention\Image\Facades\Image::make( Storage::get($image->path ) );
        $intervention->encode('webp');
        $path = GImage::slashedImageFolder() . $image->filename->filename . '.webp';
        Storage::put( $path, $intervention->stream() );

        $image->update([
            'webp_path' => $path,
            'webp_url' =>  Storage::url($path)
        ]);
    }
}
