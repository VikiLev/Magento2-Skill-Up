<?php

namespace Test\Grid\Model\ResourceModel\Grid;

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
        $this->_init(\Test\Grid\Model\Grid::class, \Test\Grid\Model\ResourceModel\Grid::class);
    }
}
