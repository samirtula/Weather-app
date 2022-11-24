<?php

require __DIR__ . '/../vendor/autoload.php';

use Octopus\WeatherApp\Controllers\WeatherAppController;

try {
    $app = (new WeatherAppController())->getApp();
} catch (\Exception $e) {
    echo 'Sorry, try later';
}

if (isset($app) && !empty($app)) :?>
    <div class="weather">
        <div class="weather__wrapper weather-data">
            <span class="weather-data__weather">
                Погода в&nbsp;местоположении <?php echo $app->getLocality()?>
            </span>
            <span class="weather-data__location">
                Температура <?php echo $app->getTemperature()?>&#176;С
            </span>
            <span class="weather-data__feels">
                Температура чувствуется как <?php echo $app->getFeels()?>&#176;С
            </span>
            <span class="weather-data__feels">
                Влажность <?php echo $app->getHumidity()?>%
            </span>
            <span class="weather-data__feels">
                Скорость ветра <?php echo $app->getWindSpeed()?> м/с
            </span>
        </div>
    </div>
<?php endif;?>

<style>
    .weather-data span {
        display: block;
    }
</style>