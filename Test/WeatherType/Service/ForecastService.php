<?php

declare(strict_types=1);

namespace Test\WeatherType\Service;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Webapi\Rest\Response;

class ForecastService
{
    private Curl $curl;

    private Response $response;

    private Json $json;

    public function __construct(
        Curl $curl,
        Json $json,
        Response $response
    ) {
        $this->curl = $curl;
        $this->json = $json;
        $this->response = $response;
    }

    /**
     * @param string $url
     * @param array $co
     * @param string $apiKey
     * @param string $units
     * @return string
     */
    public function getWeatherApiUrl(string $url, array $co, string $apiKey, string $units): string
    {
        $lat = $co['lat'];
        $lon = $co['lon'];

        return sprintf(
            "%s&lat=%s&lon=%s&appid=%s&units=%s",
            $url,
            $lat,
            $lon,
            $apiKey,
            $units
        );
    }

    /**
     * @param string $url
     * @param string $sity
     * @param string $apiKey
     * @return array|Response
     */
    public function getCoordinates(string $url, string $sity, string $apiKey)
    {
        $coordinatesUrl = sprintf("%s%s&appid=%s", $url, $sity, $apiKey);
        $this->curl->get($coordinatesUrl);
        $responseJson = $this->curl->getBody();
        $responseData = $this->json->unserialize($responseJson);
        $responseDataArray = $responseData[0];

        return [
            'lat' => $responseDataArray['lat'],
            'lon' => $responseDataArray['lon'],
        ];
    }
}
