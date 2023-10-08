<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class AccuWeatherService implements WeatherInterface
{
    const ACCU_WEATHER = 'accu-weather';
    const URL_FIRST = 'http://dataservice.accuweather.com/locations/v1/cities/search';
    const URL_SECOND = 'http://dataservice.accuweather.com/currentconditions/v1';


    public function getWeather(string $city)
    {
        try {
            $accuWeather = Http::get(self::URL_FIRST.'?apikey='.env('ACCU_WEATHER').'&q='.$city);
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
        $getWeather = Http::get(self::URL_SECOND.'/'.$key.'?apikey='.env('ACCU_WEATHER'));
        $data = json_decode($getWeather->getBody());
        return  $data[0]->Temperature->Metric->Value ?? null;
    }

    public static function getName(): string
    {
        return self::ACCU_WEATHER;
    }
}
