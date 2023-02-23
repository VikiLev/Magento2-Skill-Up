<?php

namespace Test\GraphQL\Model;

use Test\GraphQL\Model\ResourceModel\GraphQL as GraphQLResourceModel;
use Magento\Framework\Model\AbstractModel;

class GraphQL extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(GraphQLResourceModel::class);
    }
}
