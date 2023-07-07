<?php

declare(strict_types=1);

namespace Test\StoreReviews\Model;

use Test\StoreReviews\Api\Data\ReviewInterface;
use Magento\Framework\Model\AbstractModel;

class Review extends AbstractModel implements ReviewInterface
{

    const TABLE_NAME = 'store_reviews';

    const ENTITY_ID = 'entity_id';

    const TITLE = 'title';
    const REVIEW = 'review';
    const PROS = 'pros';
    const CONS = 'cons';

    protected function _construct()
    {
        $this->_init(\Test\StoreReviews\Model\ResourceModel\Review::class);
    }

    /**
     * @param string $title
     * @return ReviewInterface
     */
    public function setTitle(string $title): ReviewInterface
    {
        $this->setData(self::TITLE, $title);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @param string $review
     * @return ReviewInterface
     */
    public function setReview(string $review)
    {
        $this->setData(self::REVIEW, $review);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReview(): ?string
    {
        return $this->getData(self::REVIEW);
    }

    /**
     * @param string $pros
     * @return ReviewInterface
     */
    public function setPros(string $pros): ReviewInterface
    {
        $this->setData(self::PROS, $pros);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPros(): ?string
    {
        return $this->getData(self::PROS);
    }

    /**
     * @param string $cons
     * @return ReviewInterface
     */
    public function setCons(string $cons): ReviewInterface
    {
        $this->setData(self::CONS, $cons);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCons(): ?string
    {
        return $this->getData(self::CONS);
    }
}
