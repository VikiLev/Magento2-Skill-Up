<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Grid\Ui\Component\Listing;

use Test\Grid\Model\ResourceModel\Grid\CollectionFactory;

/**
 * DataProvider for cms ui.
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    private CollectionFactory $collectionFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
}
