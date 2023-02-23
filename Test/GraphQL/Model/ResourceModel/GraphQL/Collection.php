<?php

namespace Test\GraphQL\Model\ResourceModel\GraphQL;

use Test\GraphQL\Model\GraphQL as GraphQLModel;
use Test\GraphQL\Model\ResourceModel\GraphQL as GraphQLResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            GraphQLModel::class,
            GraphQLResourceModel::class
        );
    }
}
