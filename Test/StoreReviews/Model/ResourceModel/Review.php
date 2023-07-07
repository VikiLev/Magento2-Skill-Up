<?php

declare(strict_types=1);

namespace Test\StoreReviews\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Review extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('store_reviews', 'entity_id');
    }
}
