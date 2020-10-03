<?php


namespace App\Http\Enumerations;


use Spatie\Enum\Enum;

final class PriceType extends Enum
{
    const Percent = "Percent";
    const Fixed = "Fixed";

}
