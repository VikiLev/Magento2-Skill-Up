<?php

declare(strict_types=1);

namespace Test\WeatherType\Api;

interface ProductRepositoryInterface
{
    /**
     * Return a filtered product.
     *
     * @param int $id
     * @return \Test\WeatherType\Api\ResponseItemInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getItem(int $id);

    /**
     * @param string $city
     * @return \Test\WeatherType\Api\ResponseItemInterface[]
     */
    public function getList(string $city);
}
