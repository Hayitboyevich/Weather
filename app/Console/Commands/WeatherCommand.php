<?php

namespace App\Console\Commands;

use App\Notifications\SendMailMessageNotification;
use App\Notifications\SendTelegramMessageNotification;
use App\Service\AccuWeatherService;
use App\Service\OpenWeatherService;
use App\Service\Weather;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class WeatherCommand extends Command
{
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
        try {

            $weather = Weather::fabric($this->argument('provider'))->getWeather($this->argument('city'));

            if (empty($channel = explode(':', $this->argument('channel')))) {
                throw new \Exception('Channel required argument');
            }

            switch ($channel[0]) {
                case 'telegram':
                    $chatId = $channel[1];
                    Notification::route('telegram', $chatId)
                        ->notify(new SendTelegramMessageNotification($weather, $this->argument('city')));
                    break;
                case 'mail':
                    $mail = $channel[1];
                    Notification::route('mail', $mail)
                        ->notify(new SendMailMessageNotification($weather, $this->argument('city')));
                    break;
                default:
                    echo $this->argument('city') . ": " . $weather;

            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}
