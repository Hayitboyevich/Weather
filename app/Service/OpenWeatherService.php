<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class OpenWeatherService
{
    const KEY = 'd7f030e1b1b35529aee8504dbc900ed3';
    const URL = 'https://api.openweathermap.org/data/2.5/weather';

    public static function getWeather($city)
    {
        $openWeather = Http::get(self::URL.'?q='.$city.'&appid='.self::KEY.'&units=metric');
        $data = json_decode($openWeather->getBody());
        return  $data->main->temp;
    }
}
