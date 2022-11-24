<?php

namespace Octopus\WeatherApp\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class HTTPController
{
    private string $serviceURI;
    private Client $client;
    protected Logger $logger;

    public function __construct(string $serviceURI, array $config = [])
    {
        $this->serviceURI = $serviceURI;
        $this->client = new Client($config);
        $this->logger = new Logger(__CLASS__);

        $this->logger->pushHandler(new StreamHandler(
            __DIR__ . '/../../logs/HTTPController.log',
            $this->logger::INFO
        ));
    }

    public function getData()
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->serviceURI,
                [
                    'headers' => [
                        'X-Yandex-API-Key' => getenv('API_KEY')
                    ],
                ]
            );
            $responseData = json_decode($response->getBody()->getContents(), true);
            $this->logger->info('ResponseData', $responseData);

            return $responseData;
        } catch (GuzzleException $e) {
            $this->logger->error('ErrorGuzzle', ['Message' => $e->getMessage()]);
        }
    }
}
