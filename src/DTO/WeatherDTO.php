<?php

namespace Octopus\WeatherApp\DTO;

class WeatherDTO
{
    protected float $temperature;
    protected float $feels;
    protected float $windSpeed;
    protected float $humidity;
    protected string $locality;

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function setLocality(string $locality): void
    {
        $this->locality = $locality;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    public function getFeels(): float
    {
        return $this->feels;
    }

    public function setFeels(float $feels): void
    {
        $this->feels = $feels;
    }

    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed): void
    {
        $this->windSpeed = $windSpeed;
    }

    /**
     * @return float
     */
    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): void
    {
        $this->humidity = $humidity;
    }
}
