<?php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Octopus\WeatherApp\Controllers\WeatherAppController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('Weather');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/Weather.log', $logger::INFO));

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $weatherData = (new WeatherAppController())->getWeather(getenv('POSITION_LAT'), getenv('POSITION_LON'));
} catch (\Exception $e) {
    $logger->error($e->getMessage());
    echo 'Sorry, try later';
}
?>

<?php if (isset($weatherData) && !empty($weatherData)) :?>
    <div class="weather">
        <div class="weather__wrapper weather-data">
            <span class="weather-data__weather">
                Погода в&nbsp;местоположении <?php echo $weatherData->getLocality()?>
            </span>
            <span class="weather-data__location">
                Температура <?php echo $weatherData->getTemperature()?>&#176;С
            </span>
            <span class="weather-data__feels">
                Температура чувствуется как <?php echo $weatherData->getFeels()?>&#176;С
            </span>
            <span class="weather-data__feels">
                Влажность <?php echo $weatherData->getHumidity()?>%
            </span>
            <span class="weather-data__feels">
                Скорость ветра <?php echo $weatherData->getWindSpeed()?> м/с
            </span>
        </div>
    </div>
<?php endif;?>

<style>
    .weather-data span {
        display: block;
    }
</style>