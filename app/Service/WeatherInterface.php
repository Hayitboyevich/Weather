<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

interface WeatherInterface
{
    public  function getWeather(string $city);

    public static function getName():string;
}
