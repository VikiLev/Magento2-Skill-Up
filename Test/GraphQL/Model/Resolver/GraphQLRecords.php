<?php

namespace Test\GraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
class GraphQLRecords implements ResolverInterface
{
    private $graphQLRecords;

    public function __construct(
        \Test\GraphQL\Model\Resolver\DataProvider\GraphQLRecords $graphQLRecords
    ) {
        $this->graphQLRecords = $graphQLRecords;
    }

    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $graphQLRecords = $this->graphQLRecords->getRecords();
        return $graphQLRecords;
    }
}
