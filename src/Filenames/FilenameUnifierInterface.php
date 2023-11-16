<?php

namespace Gepopp\Image\Filenames;

interface FilenameUnifierInterface
{
    public static function getFilenameUnifier( Filename $filename ) : string;
}
