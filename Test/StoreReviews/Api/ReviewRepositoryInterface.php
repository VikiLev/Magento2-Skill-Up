<?php

declare(strict_types=1);

namespace Test\StoreReviews\Api;

use Test\StoreReviews\Api\Data\ReviewInterface;

interface ReviewRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @return \Test\StoreReviews\Model\Review
     */
    public function getReview();

    /**
     * @param ReviewInterface $reviews
     * @return mixed
     */
    public function save(ReviewInterface $contact);


    /**
     * @return \Test\StoreReviews\Api\Data\ReviewInterface[]|\Magento\Framework\DataObject[]
     */
    public function getList();

    /**
     * @param ReviewInterface $contact
     * @return mixed
     */
    public function delete(ReviewInterface $contact);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id);
}
