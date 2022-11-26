<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<?php

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = (new Octopus\WeatherApp\Controllers\WeatherAppController())->getApp();
} catch (\Exception $e) {
    echo 'Sorry, try later';
}
?>
<body>
<? if (isset($app) && !empty($app)) : ?>
    <div class="weather">
        <div class="weather__wrapper weather-data">
            <span class="weather-data__weather">
                Погода в  <?php echo $app->getLocality() ?>
            </span>
            <span class="weather-data__location">
                Температура <?php echo $app->getTemperature() ?>&#176;С
            </span>
            <span class="weather-data__feels">
                Температура чувствуется как <?php echo $app->getFeels() ?>&#176;С
            </span>
            <span class="weather-data__feels">
                Влажность <?php echo $app->getHumidity() ?>%
            </span>
            <span class="weather-data__feels">
                Скорость ветра <?php echo $app->getWindSpeed() ?> м/с
            </span>
        </div>
    </div>
<?php endif; ?>
</body>
</html>
<style>
    .weather-data span {
        display: block;
    }
</style>