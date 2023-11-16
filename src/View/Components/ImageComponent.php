<?php

namespace Gepopp\Image\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageComponent extends Component
{

    public \Gepopp\Image\Model\Image $image;
    /**
     * Create a new component instance.
     */
    public function __construct( \Gepopp\Image\Model\Image $image )
    {
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
       return view('gepopp::components.image', ['image' => $this->image]);
    }
}
