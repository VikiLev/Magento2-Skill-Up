<?php

namespace Test\GraphQL\Model\Resolver\DataProvider;

class GraphQLRecords
{
    private $graphQLFactory;
    public function __construct(
        \Test\GraphQL\Model\GraphQLFactory $graphQLFactory
    ) {
        $this->graphQLFactory= $graphQLFactory;
    }
    public function getRecords()
    {
        try {
            $collection = $this->graphQLFactory->create()->getCollection();
            $Records = $collection->getData();

        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $Records;
    }
}
