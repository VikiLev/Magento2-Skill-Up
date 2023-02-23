<?php

namespace Test\GraphQL\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Module\Setup\Migration;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class AddData implements DataPatchInterface
{
    private $graphQLFactory;

    public function __construct(
        \Test\GraphQL\Model\GraphQLFactory $graphQLFactory
    ) {
        $this->graphQLFactory = $graphQLFactory;
    }

    public function apply()
    {
        $sampleData = [
            [
                'status' => 1,
                'custom_field_1' => 'Sample Text 1 for Data 1',
                'custom_field_2' => 'Sample Text 2 for Data 1'
            ],
            [
                'status' => 1,
                'custom_field_1' => 'Sample Text 1 for Data 2',
                'custom_field_2' => 'Sample Text 2 for Data 2'
            ]
        ];
        foreach ($sampleData as $data) {
            $this->graphQLFactory->create()->setData($data)->save();
        }
    }
    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
