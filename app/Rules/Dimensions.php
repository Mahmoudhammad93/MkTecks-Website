<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Intervention\Image\Facades\Image;

class Dimensions implements Rule
{
    protected $maxWidth;
    protected $maxHeight;

    public function __construct($maxWidth, $maxHeight)
    {
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
    }

    public function passes($attribute, $value)
    {
        $dimensions = getimagesize($value);

        if ($dimensions === false) {
            return false;
        }

        [$width, $height] = $dimensions;

        return $width <= $this->maxWidth && $height <= $this->maxHeight;
    }

    public function message()
    {
        return "The :attribute dimensions must be equal to W{$this->maxWidth} * H{$this->maxHeight} pixels.";
    }
}
