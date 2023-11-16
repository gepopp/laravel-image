<?php

return [

    /**
     * The Folder Images are Seved in the Storage
     */
    'folder'    => 'images',


    /**
     * how filenames are cast to be unique or not
     */
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


    'create_webps'        => true,
    'queue_webp_creation' => true,


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


    'use_filename_for_empty_alt' => true

];
