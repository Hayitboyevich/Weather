<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class Weather
{
    const CLASS_LIST = [
        AccuWeatherService::class,
        OpenWeatherService::class,
    ];

    public static function fabric(string $name)
    {
        /**
         * @var $class WeatherInterface
         */
        foreach (self::CLASS_LIST as $class) {
            if ($class::getName() == $name) {
                return new $class();
            }
        }
        throw new \Exception('Provider not found');
    }
}
