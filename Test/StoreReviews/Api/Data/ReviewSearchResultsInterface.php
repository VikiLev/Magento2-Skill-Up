<?php

declare(strict_types=1);

namespace Test\StoreReviews\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;
interface ReviewSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return ReviewSearchResultsInterface
     */
    public function setItems(array $items);
}
