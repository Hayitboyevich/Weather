<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class OpenWeatherService implements WeatherInterface
{
    const URL = 'https://api.openweathermap.org/data/2.5/weather';
    const OPEN_WEATHER = 'open-weather-map';

    public  function getWeather(string $city)
    {
        $openWeather = Http::get(self::URL.'?q='.$city.'&appid='.env('OPEN_WEATHER').'&units=metric');
        $data = json_decode($openWeather->getBody());
        return  $data->main->temp;
    }

    public static function getName(): string
    {
        return self::OPEN_WEATHER;
    }
}
