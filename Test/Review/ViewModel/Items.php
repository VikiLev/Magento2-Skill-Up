<?php

declare(strict_types=1);

namespace Test\Review\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory;

class Items implements ArgumentInterface
{
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }
    public function getReviews(int $productId): array
    {
        $reviews = $this->collectionFactory->create();
        $reviews->addFieldToFilter('entity_pk_value',$productId);
        $reviews->setDateOrder();
        $reviewsItem = [];
        foreach ($reviews->getItems() as $item){
            $reviewsItem[] = $item->getData();
        }
        return $reviewsItem;
    }
}
