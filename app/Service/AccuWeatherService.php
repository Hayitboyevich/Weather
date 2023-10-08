<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class AccuWeatherService
{
    const KEY = 'az1Tg8Ku9A0P9V6XwIAGqv4ug6njmuWB';
    const URL_FIRST = 'http://dataservice.accuweather.com/locations/v1/cities/search';
    const URL_SECOND = 'http://dataservice.accuweather.com/currentconditions/v1';


    public static function getWeather($city)
    {
        try {
            $accuWeather = Http::get(self::URL_FIRST.'?apikey='.self::KEY.'&q='.$city);
            $data = json_decode($accuWeather->getBody());
            $key = $data[0]->Key;
            $weather = self::getWeatherData($key);
            return $weather;
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    private static function getWeatherData($key)
    {
        $getWeather = Http::get(self::URL_SECOND.'/'.$key.'?apikey='.self::KEY);
        $data = json_decode($getWeather->getBody());
        return  $data[0]->Temperature->Metric->Value ?? null;
    }
}
