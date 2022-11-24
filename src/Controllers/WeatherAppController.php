<?php

namespace Octopus\WeatherApp\Controllers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Octopus\WeatherApp\DTO\WeatherDTO;
use Dotenv\Dotenv;

final class WeatherAppController
{
    private const CACHE_TIME = 120;
    private const CACHE_ITEM_NAME = 'weather';

    protected Logger $logger;
    private FilesystemAdapter $cache;

    public function __construct()
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->logger = new Logger(__CLASS__);
        $this->logger->pushHandler(new StreamHandler(
            __DIR__ . '/../../logs/WeatherAppController.log',
            $this->logger::INFO
        ));
        $this->cache = new FilesystemAdapter();
    }

    private function getWeatherDTO(): WeatherDTO
    {
        $weatherCache = $this->cache->getItem(self::CACHE_ITEM_NAME);

        if (!$weatherCache->isHit()) {
            $lat = getenv('POSITION_LAT');
            $lon = getenv('POSITION_LON');
            $weather = (new HTTPController(getenv('API_URL') . "lat={$lat}&lon={$lon}"))->getData();
            $weatherCache->set($weather);
            $weatherCache->expiresAfter(self::CACHE_TIME);
            $this->cache->save($weatherCache);
        } else {
            $weather = $weatherCache->get();
        }

        if (empty($weather)) {
            throw new \Exception('Something goes wrong');
        }
        $weatherDTO = new WeatherDTO();
        $weatherDTO->setTemperature($weather['fact']['temp']);
        $weatherDTO->setFeels($weather['fact']['feels_like']);
        $weatherDTO->setHumidity($weather['fact']['humidity']);
        $weatherDTO->setWindSpeed($weather['fact']['wind_speed']);
        $weatherDTO->setLocality($weather['geo_object']['locality']['name']);

        return $weatherDTO;
    }

    public function getApp()
    {
        try {
            return $this->getWeatherDTO();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
