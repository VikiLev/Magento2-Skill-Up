<?php

declare(strict_types=1);

namespace Test\WeatherType\Block;

use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use Test\WeatherType\Service\ForecastService;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Weather extends Template
{
    private Session $customerSession;

    private CustomerRepositoryInterface $customerRepository;

    private Curl $curl;

    private Json $json;

    private ForecastService $forecastService;

    private ScopeConfigInterface $scopeConfig;

    /**
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param Curl $curl
     * @param Json $json
     * @param ForecastService $forecastService
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        Curl $curl,
        Json $json,
        ForecastService $forecastService,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->curl = $curl;
        $this->json = $json;
        $this->forecastService = $forecastService;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCustomerCity(): mixed
    {
        $customerId = $this->customerSession->getCustomer()->getId();

        if (!empty($customerId)) {
            $customerAddresses = $this->customerRepository->getById($customerId)->getAddresses();

            foreach ($customerAddresses as $address) {
                $customerAddress = $address->__toArray();

                return $customerAddress['city'];
            }
        }

        return '';
    }

    /**
     * @param $city
     * @return mixed
     */
    public function getWeather($city): mixed
    {
        $urlWeather = $this->getConfig('weather_api/settings/url_weathere',);
        $urlCoordinates = $this->getConfig('weather_api/settings/url_coordinates');
        $apiKey = $this->getConfig('weather_api/settings/api_key');
        $units = $this->getConfig('weather_api/settings/units');

        $coordinates = $this->forecastService->getCoordinates($urlCoordinates, $city, $apiKey);
        $urlWeather = $this->forecastService->getWeatherApiUrl($urlWeather, $coordinates, $apiKey, $units);
        $this->curl->get($urlWeather);
        $responseJson = $this->curl->getBody();
        $responseData =  $this->json->unserialize($responseJson);
        $responseDataArray = $responseData['main'];

        return $responseDataArray['temp'];
    }

    /**
     * @param string $path
     * @return mixed
     */
     public function getConfig(string $path): mixed
     {
         return $this->scopeConfig->getValue(
             $path,
             \Magento\Store\Model\ScopeInterface::SCOPE_STORE
         );
     }

}
