<?php

namespace Test\Grid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Grid extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('test_table_grid', 'entity_id');
    }
}
