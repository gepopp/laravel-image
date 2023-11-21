# Image

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]


This package is ment to reduce the effort when you need an image model with a srcset and multiple image sizes in your laravel project.

## Installation

Via Composer

```bash
composer require gepopp/image
```

## Usage
With the package comes a Image model like so:
```
Schema::create( 'images', function ( Blueprint $table ) {
            $table->id();
            $table->string('filename');
            $table->string( 'path' )->nullable();
            $table->string( 'webp_path' )->nullable();
            $table->string( 'url' )->nullable();
            $table->string( 'webp_url' )->nullable();
            $table->string( 'mime' )->nullable();
            $table->unsignedInteger( 'width' )->nullable();
            $table->unsignedInteger( 'height' )->nullable();
            $table->unsignedInteger( 'size' )->nullable();
            $table->json( 'sizes' )->nullable();
            $table->json( 'webp_sizes' )->nullable();
            $table->text( 'srcset' )->nullable();
            $table->text( 'webp_srcset' )->nullable();
            $table->string( 'alt' )->nullable();
            $table->json( 'meta' )->nullable();
            $table->softDeletes();
            $table->timestamps();
        } );
```
It holds all nesscesary information about uploaded images. 
However you can create a new image with the minimum of a filename. There is a ImageObserver that takes care of inserting all the other data by using the [https://image.intervention.io/v2](Intervention Image Library).
Various images sizes, default sizes accordingly to tailwind breakpoints, are created via jobs dispatched on the queue. You can also customize the sizes and how they are created, please se the config file that can be published vie
```bash
php artisan vendor:publish image.config
```
Image sizes are defined as an array of arrays, default:
```
'image_sizes' => [
        'create'      => true,
        'create_webp' => true,
        'queue'       => true,
        'sizes'       => [
            [ 150, 150, true ],
            [ 100, 100, true ],
            [ 300, null, false ],
            [ 320, null, false ],
            [ 640, null, false ],
            [ 600, null, false ],
            [ 768, null, false ],
            [ 1024, null, false ],
            [ 1280, null, false ],
            [ 1536, null, false ],
        ],
    ],
```
Where the first value in the size array is the image width, the second one the image height and the bool determines if the new size is created be the
[https://image.intervention.io/v2/api/fit](fit) function of intervention image = gets cropped or if its just [https://image.intervention.io/v2/api/resize](resized).
If the image gets resizes the height value might be ignored because the image ration will allways be preserved.

## Unique Filenames
The package comes with a simple setting how unique filename might be created:
```
 'filenames' => [
        // make the filenames unique to avoid overriding
        'unify'             => true,
        // class used to unify filenames
        'unifiy_with'       => \Gepopp\Image\Filenames\ImageCounterFilenameUnifier::class,
        // place the unifier at end or start of the original filename
        'unify_at'          => 'end',
        'slugify_filenames' => true,
        'slugify_with'      => '_',

    ],
```
There are three unifier classes:
```
\Gepopp\Image\Filenames\ImageCounterFilenameUnifier::class
## it returns an incremented number if the filename allready exists in the images folder on the dist

\Gepopp\Image\Filenames\ImageMircotimeFilenameUnifier::class
## it returns a microtime-timesteamp without . 

\Gepopp\Image\Filenames\ImageUlidFilenameUnifier::class
## It returns a Str::ulid unique string
```
This unifier is then appended or prepended to the filename by using the static:
```
Gepopp\Image\Image::getMaybeUnifiedFilename( $filename );
```
method.


## Laravel Nova Resource

The package also includes a laravel nova 4 resource file. It can be published to your project via
```bash
php artisan vendor:publish image.nova.resource
```

## Blade Image Component

There is also a simple blade component to include images into your blade views it can be publised and customized via
```bash
php artisan vendor:publish image.views
```


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author@email.com instead of using the issue tracker.

## Credits

- [Gerhard Popp][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/gepopp/image.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/gepopp/image.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/gepopp/image/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/gepopp/image
[link-downloads]: https://packagist.org/packages/gepopp/image
[link-travis]: https://travis-ci.org/gepopp/image
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/gepopp
[link-contributors]: ../../contributors
