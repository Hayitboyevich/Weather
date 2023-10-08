<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $accuWeather = Http::get('http://dataservice.accuweather.com/locations/v1/cities/search?apikey=LFkfsNOeb6uUrbrVEey3kHHYcISY1Xyd&q=tashkent');
    $json = json_decode($accuWeather->getBody());
    $key = $json[0]->Key;

    $getWeather = Http::get('http://dataservice.accuweather.com/currentconditions/v1/'.$key.'?apikey=LFkfsNOeb6uUrbrVEey3kHHYcISY1Xyd');
    $data = json_decode($getWeather->getBody());
    dd($data[0]->Temperature->Metric->Value);
//    $openWeather = Http::get('https://api.openweathermap.org/data/2.5/weather?q=tashkent&appid=d7f030e1b1b35529aee8504dbc900ed3&units=metric');
//    $json = json_decode($openWeather->getBody());

});
