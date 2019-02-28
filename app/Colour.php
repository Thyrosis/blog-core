<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Colour extends Model
{
    // const COLOURS = array(
    //     "#FF9797", "#FF97E8", "#FF97CB", "#FE98F1", "#ED9EFE", "#E29BFD", "#B89AFE",
    //     "#DD75DD", "#BD5CFE", "#AE70ED", "#9588EC", "#6094DB", "#44B4D5",
    //     "#8C8CFF", "#99C7FF", "#99E0FF", "#63E9FC", "#74FEF8", "#62FDCE", "#72FE95",
    //     "#7CEB98", "#93BF96", "#99FD77", "#52FF20", "#95FF4F", "#FFFFAA", "#EDEF85"
    // );

    const COLOURS = array(
        "#600110", /* red */
        "#ff3200", /* orange */
        // "#fbf314", /* yellow */
        "#3bd92a", /* green */
        "#006ce3", /* blue */
        "#6a318f", /* purple */
    );

    public static function select()
    {
        return Arr::random(self::COLOURS);
    }
}
