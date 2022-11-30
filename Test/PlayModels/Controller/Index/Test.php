<?php

declare (strict_types=1);

namespace Test\PlayModels\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

class Test implements HttpGetActionInterface
{
    private \Test\PlayModels\Model\CardFactory $cardModel;

    private \Test\PlayModels\Model\ResourceModel\Card $cardResourceModel;

    private \Magento\Framework\View\Result\PageFactory $pageFactory;

    private \Test\PlayModels\Model\ResourceModel\Card\CollectionFactory $collectionFactory;

    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;


    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Test\PlayModels\Model\CardFactory $cardModel,
        \Test\PlayModels\Model\ResourceModel\Card $cardResourceModel,
        \Test\PlayModels\Model\ResourceModel\Card\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->cardModel = $cardModel;
        $this->cardResourceModel = $cardResourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function execute()
    {

        //create

        $newCard = $this->cardModel->create();
        $newCard->setTitle('test Title 2');
        $newCard->setIdentifier('test Edentifier 2');
        $newCard->setContent('test content');

        $this->cardResourceModel->save($newCard);

        //load

        $cardToLoad = $this->cardModel->create();
        $this->cardResourceModel->load($cardToLoad, 1);

//        echo $cardToLoad->getTitle();

        //update

        $cardToUpdate = $this->cardModel->create();
        $this->cardResourceModel->load($cardToLoad, 1);
        $cardToUpdate->setTitle( $cardToUpdate->getTitle(). 'Custom Update');
        $this->cardResourceModel->save($cardToUpdate);



        //delete
        $cardToDelete = $this->cardModel->create();
        $this->cardResourceModel->load($cardToLoad, 3);
        $this->cardResourceModel->delete($cardToDelete);


        // collection

        $cardCollection = $this->collectionFactory->create();
//        $cardCollection->addFilterToSelect('*');
        $cardCollection->addFieldToSelect(['title', 'content']);
        $cardCollection->addFieldToSelect('identifier');
        $cardCollection->addFieldToFilter('is_active', 1);

        $cardCollection->addOrder('creation_time', 'ASC');


        $cardCollection->setPageSize(2);
        $cardCollection->setCurPage(2);


//        foreach ($cardCollection->getItems() as $item) {
//            echo $item->getId();
//            echo $item->getTitle();
//            echo $item->getContent();
//        }


//        echo $cardCollection->getSelect();


        // collection Product EAV

        $productCollection = $this->productCollectionFactory->create();
//        $productCollection->addAttributeToFilter('name', 'Kangoo');
        $productCollection->addAttributeToSelect('*');
//        $productCollection->addAttributeToSort('tax_class_id');
        $productCollection->setPageSize(2);

        foreach ($productCollection as $product) {
            print_r($product->debug());
            print_r($product->getdata());
        }

        echo  $productCollection->getSelect();


        return $this->pageFactory->create();
    }
}
