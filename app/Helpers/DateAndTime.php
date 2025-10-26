<?php

use Carbon\Carbon;

if (!function_exists('carbonate')) {
    function carbonate($dateOrTime): string
    {
        return Carbon::parse($dateOrTime)->diffForHumans();
    }
}
