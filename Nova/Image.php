<?php

namespace Gepopp\Image\Nova;

use App\Nova\Resource;
use Gepopp\Image\Image as GImage;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image as ImageField;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Image extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Gepopp\Image\Model\Image>
     */
    public static $model = \Gepopp\Image\Model\Image::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function fields( NovaRequest $request )
    {
        return [
            ID::make()->sortable(),
            ImageField::make( 'Pfad', 'filename' )
                      ->store( function ( Request $request, $model ) {
                          $filename = GImage::getMaybeUnifiedFilename( $request->filename->getClientOriginalName() );
                          $request->filename->storeAs( config( 'image.folder' ), $filename, config( 'filesystems.default' ) );

                          return [
                              'filename' => $filename,
                          ];
                      } )
                      ->preview( function ( $value, $disk ) {
                          return is_null( $this->model()->webp_url ) ? $this->model()->url : $this->model()->webp_url;
                      } )
                      ->thumbnail( function ( $value, $disk ) {
                          return is_null( $this->model()->webp_url ) ? $this->model()->url : $this->model()->webp_url;
                      } )
                      ->creationRules( [ 'required', 'image' ] ),
            Text::make( 'Alt Tag', 'alt' )
                ->rules( [ 'nullable', 'string', 'max:250' ] ),

            KeyValue::make( 'Meta' )
                    ->rules( [ 'nullable', 'array' ] ),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function cards( NovaRequest $request )
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function filters( NovaRequest $request )
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function lenses( NovaRequest $request )
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     *
     * @return array
     */
    public function actions( NovaRequest $request )
    {
        return [];
    }
}
