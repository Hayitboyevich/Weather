<?php

namespace App\Console\Commands;

use App\Notifications\SendMailMessageNotification;
use App\Notifications\SendTelegramMessageNotification;
use App\Service\AccuWeatherService;
use App\Service\OpenWeatherService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class WeatherCommand extends Command
{
    const OPEN_WEATHER = 'open-weather-map';
    const ACCU_WEATHER = 'accu-weather';
    const DARK_SKY = 'dark-sky';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather {provider} {city} {channel?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $weather = '';
        if ($this->argument('provider') == self::ACCU_WEATHER){
            $weather = AccuWeatherService::getWeather($this->argument('city'));
        }elseif ($this->argument('provider') == self::OPEN_WEATHER){
            $weather = OpenWeatherService::getWeather($this->argument('city'));
        }

        if (explode(':', $this->argument('channel'))[0] == 'telegram'){
            $chatId = explode(':', $this->argument('channel'))[1];
            Notification::route('telegram', $chatId)
            ->notify(new SendTelegramMessageNotification($weather, $this->argument('city')));
        }
        elseif(explode(':', $this->argument('channel'))[0] == 'mail'){
            $mail = explode(':', $this->argument('channel'))[1];
            Notification::route('mail', $mail)
                ->notify(new SendMailMessageNotification($weather, $this->argument('city')));
        }else{
            echo $this->argument('city').": ".$weather;
        }
    }
}
