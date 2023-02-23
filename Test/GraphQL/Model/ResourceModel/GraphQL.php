<?php

namespace Test\GraphQL\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GraphQL extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('test_graphql', 'id');
    }
}
