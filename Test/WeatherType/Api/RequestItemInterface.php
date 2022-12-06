<?php

declare(strict_types=1);

namespace Test\WeatherType\Api;

interface RequestItemInterface
{
    const DATA_ID = 'id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id);
}
