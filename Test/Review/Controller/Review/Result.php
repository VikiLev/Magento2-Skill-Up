<?php

declare(strict_types=1);

namespace Test\Review\Controller\Review;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Review\Model\ReviewFactory;
use Magento\Review\Model\Review;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session;
use Magento\Review\Model\ResourceModel\Review\CollectionFactory;

class Result implements HttpPostActionInterface
{
    private JsonFactory $jsonFactory;
    private RequestInterface $request;
    private ReviewFactory $reviewModel;

    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param ReviewFactory $reviewModel
     * @param StoreManagerInterface $storeManager
     * @param Session $session
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        JsonFactory      $jsonFactory,
        RequestInterface $request,
        ReviewFactory $reviewModel,
        StoreManagerInterface $storeManager,
        Session $session,
        CollectionFactory $collectionFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->reviewModel = $reviewModel;
        $this->storeManager = $storeManager;
        $this->session = $session;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $nickname = (string)$this->request->getParam('nickName');
        $review = (string)$this->request->getParam('review');
        $productId = $this->request->getParam('productId');
        $title = $this->request->getParam('title');

        $jsonResult = $this->jsonFactory->create();
        $reviewModel = $this->reviewModel->create();
        $reviewModel->setNickname($nickname);
        $reviewModel->setDetail($review);
        $reviewModel->setTitle($title);

        $reviewModel->unsetData('review_id');

        $reviewModel->setEntityId($reviewModel->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
            ->setEntityPkValue($productId)
            ->setStatusId(Review::STATUS_APPROVED)
            ->setCustomerId($this->session->getCustomerId())
            ->setStoreId($this->storeManager->getStore()->getId())
            ->setStores([$this->storeManager->getStore()->getId()])
            ->save();

        $reviewModel->aggregate();

        $reviews = $this->collectionFactory->create();
        $reviews->addFieldToFilter('entity_pk_value',$productId);
        $reviews->setDateOrder();
        $reviewsItem = [];
        foreach ($reviews->getItems() as $item){
            $reviewsItem[] = $item->getData();
        }
        $jsonResult->setData(['reviews'=>\Zend_Json::encode($reviewsItem)]);

        return $jsonResult;
    }
}
