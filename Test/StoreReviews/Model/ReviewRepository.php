<?php

declare(strict_types=1);

namespace Test\StoreReviews\Model;

use Test\StoreReviews\Api\ReviewRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Test\StoreReviews\Model\ReviewFactory;
use Test\StoreReviews\Model\ResourceModel\Review as ResourceModel;
use Test\StoreReviews\Model\ResourceModel\Review\CollectionFactory;
use Test\StoreReviews\Api\Data\ReviewInterface;
use Test\StoreReviews\Api\Data\ReviewInterfaceFactory;
use Test\StoreReviews\Api\Data\ReviewSearchResultsInterfaceFactory;

class ReviewRepository implements ReviewRepositoryInterface
{
    private ReviewSearchResultsInterfaceFactory $searchResultFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private CollectionFactory $collectionFactory;
    private ResourceModel $resourceModel;
    private LoggerInterface $logger;
    private ReviewInterfaceFactory $modelFactory;
    private \Test\StoreReviews\Model\ReviewFactory $reviewFactory;

    public function __construct(
        LoggerInterface $logger,
        ReviewInterfaceFactory $reviewInterfaceFactory,
        ResourceModel $resourceModel,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ReviewSearchResultsInterfaceFactory $searchResultFactory,
        ReviewFactory $reviewFactory
    ) {
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->resourceModel = $resourceModel;
        $this->logger = $logger;
        $this->modelFactory = $reviewInterfaceFactory;
        $this->reviewFactory = $reviewFactory;
    }

    public function getById(int $id): ReviewInterface
    {
        $model = $this->modelFactory->create();

        $this->resourceModel->load($model, $id);

        if (null === $model->getId()) {
            throw new NoSuchEntityException(__('Model with %1 not found', $id));
        }

        return $model;
    }
    /**
     * @return Review
     */
    public function getReview(): Review
    {
        return$this->reviewFactory->create();
    }

    /**
     * @return \Test\StoreReviews\Api\Data\ReviewInterface[]|\Magento\Framework\DataObject[]
     */
    public function getList()
    {
        return $this->collectionFactory->create()->getItems();
    }

    /**
     * @param ReviewInterface $review
     * @return $this|ReviewRepositoryInterface
     * @throws CouldNotSaveException
     */
    public function save(ReviewInterface $review): ReviewRepositoryInterface
    {
        try {
            $this->resourceModel->save($review);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__("review not saved"));
        }

        return  $this;
    }

    /**
     * @param ReviewInterface $review
     * @return $this|ReviewRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(ReviewInterface $review): ReviewRepositoryInterface
    {
        try {
            $this->resourceModel->delete($review);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__("review %1 not deleted", $review->getId()));
        }
        return  $this;
    }

    /**
     * @param int $id
     * @return $this|ReviewRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): ReviewRepositoryInterface
    {
        try {
            $model = $this->getById($id);
            $this->delete($model);
        } catch (NoSuchEntityException $e) {
            $this->logger->warning(sprintf("review %d already deleted or not found", $id));
        }
        return $this;
    }
}
