<?php

declare(strict_types=1);

namespace Test\WeatherType\Model\Api;

use Test\WeatherType\Api\ProductRepositoryInterface;
use Test\WeatherType\Api\RequestItemInterfaceFactory;
use Test\WeatherType\Api\ResponseItemInterfaceFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Test\WeatherType\Block\Weather;
use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Framework\Webapi\Rest\Response;
use Test\WeatherType\Service\ForecastService;

class ProductRepository implements ProductRepositoryInterface
{
    private Weather $weather;

    private StoreManagerInterface $storeManager;

    private ResponseItemInterfaceFactory $responseItemFactory;

    private RequestItemInterfaceFactory $requestItemFactory;

    private CollectionFactory $productCollectionFactory;

    private Action $productAction;

    private Repository $repository;

    private Response $response;

    private ForecastService $forecastService;

    /**
     * @param Action $productAction
     * @param CollectionFactory $productCollectionFactory
     * @param RequestItemInterfaceFactory $requestItemFactory
     * @param ResponseItemInterfaceFactory $responseItemFactory
     * @param StoreManagerInterface $storeManager
     * @param Weather $weather
     * @param Repository $repository
     */
    public function __construct(
        Action $productAction,
        CollectionFactory $productCollectionFactory,
        RequestItemInterfaceFactory $requestItemFactory,
        ResponseItemInterfaceFactory $responseItemFactory,
        StoreManagerInterface $storeManager,
        Weather $weather,
        Repository $repository,
        Response $response,
        ForecastService $forecastService
    ) {
        $this->productAction = $productAction;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->requestItemFactory = $requestItemFactory;
        $this->responseItemFactory = $responseItemFactory;
        $this->storeManager = $storeManager;
        $this->weather = $weather;
        $this->repository = $repository;
        $this->response = $response;
        $this->forecastService = $forecastService;
    }

    /**
     *
     * @param int $id
     * @return \Test\WeatherType\Api\ResponseItemInterface
     */
    public function getItem(int $id)
    {
        $collection = $this->getProductCollection()
            ->addAttributeToFilter('entity_id', ['eq' => $id]);

        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        $product = $collection->getFirstItem();
        if (!$product->getId()) {
            throw new NoSuchEntityException(__('Product not found'));
        }

        return $this->getResponseItemFromProduct($product);
    }

    /**
     * @param string $city
     * @return array|\Test\WeatherType\Api\ResponseItemInterface[]
     * @throws NoSuchEntityException
     */
    public function getList(string $city): array
    {
        if (!($this->isCityExists($city))){
            $this->response->addMessage('the city name is incorrect, please check and try again', '400');
            return [];
        }

        $collection = $this->getProductCollection();
        $weatherType = $this->getWeatherType($city);
        $optionId = $this->getOptionIdbyAttributeCode('weather_type', $weatherType);
        $collection->addAttributeToFilter('weather_type', $optionId);
        $size = $this->weather->getConfig('weather_api/settings/size');
        $collection->setPageSize($size);

        $result = [];
        /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
        foreach ($collection->getItems() as $product) {
            $result[] = $this->getResponseItemFromProduct($product);
        }

        return $result;
    }

    /**
     * @return array|\Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    private function getProductCollection()
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['entity_id', ProductInterface::SKU, ProductInterface::NAME, 'weather_type'], 'left');

        return $collection;
    }

    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Test\WeatherType\Api\ResponseItemInterface
     */
    private function getResponseItemFromProduct(ProductInterface $product)
    {
        /** @var \Test\WeatherType\Api\ResponseItemInterface $responseItem */
        $responseItem = $this->responseItemFactory->create();

        $responseItem->setId((int)$product->getId())
            ->setSku($product->getSku())
            ->setName($product->getName());

        return $responseItem;
    }

    /**
     * @param string $attrCode
     * @param string $optionText
     * @return mixed
     * @throws NoSuchEntityException
     */
    private function getOptionIdbyAttributeCode(string $attrCode, string $optionText)
    {
        $attribute =$this->repository->get($attrCode);

        return  $attribute->getSource()->getOptionId($optionText);
    }

    /**
     * @return string
     */
    private function getWeatherType($city): string
    {
        $weather = $this->weather->getWeather($city);
        $weatherFeeling = '';

        if ($weather <= 3) {
           $weatherFeeling = 'cold';
        } elseif ( $weather > 3 || $weather <= 10) {
            $weatherFeeling = 'normal';
        } elseif ($weather > 10 || $weather <= 24) {
        $weatherFeeling = 'warm';
        } else  $weatherFeeling = 'hot';

        return $weatherFeeling;
    }

    /**
     * @param $city
     * @return bool
     */
    private function isCityExists($city): bool
    {
        try {
            $urlCoordinates = $this->weather->getConfig('weather_api/settings/url_coordinates');
            $apiKey = $this->weather->getConfig('weather_api/settings/api_key');
            $this->forecastService->getCoordinates($urlCoordinates, $city, $apiKey);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
