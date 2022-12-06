<?php

declare(strict_types=1);

namespace Test\WeatherType\Model\Api;

use Test\WeatherType\Api\RequestItemInterface;
use Magento\Framework\DataObject;

class RequestItem extends DataObject implements RequestItemInterface
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->_getData(self::DATA_ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        return $this->setData(self::DATA_ID, $id);
    }
}
