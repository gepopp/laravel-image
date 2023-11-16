<?php

namespace Gepopp\Image\Filenames;

use Illuminate\Support\Str;

class ImageUlidFilenameUnifier implements FilenameUnifierInterface
{

	public static function getFilenameUnifier( Filename $filename ): string
	{
		return Str::ulid();
	}
}
