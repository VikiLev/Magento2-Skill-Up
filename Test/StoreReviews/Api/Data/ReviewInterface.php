<?php

declare(strict_types=1);

namespace Test\StoreReviews\Api\Data;

interface ReviewInterface
{
    const ID_FIELD = 'entity_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $title
     * @return mixed
     */
    public function setTitle(string $title);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param string $review
     * @return mixed
     */
    public function setReview(string $review);

    /**
     * @return mixed
     */
    public function getReview();

    /**
     * @param string $pros
     * @return mixed
     */
    public function setPros(string $pros);

    /**
     * @return mixed
     */
    public function getPros();

    /**
     * @param string $cons
     * @return mixed
     */
    public function setCons(string $cons);

    /**
     * @return mixed
     */
    public function getCons();
}
