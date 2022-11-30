<?php

namespace Test\PlayModels\Model\ResourceModel\Card;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * CMS Block Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Test\PlayModels\Model\Card::class, \Test\PlayModels\Model\ResourceModel\Card::class);
    }
}
