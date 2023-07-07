<?php

declare(strict_types=1);

namespace Test\StoreReviews\Model\ResourceModel\Review;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(\Test\StoreReviews\Model\Review::class,
            \Test\StoreReviews\Model\ResourceModel\Review::class);
    }
}
