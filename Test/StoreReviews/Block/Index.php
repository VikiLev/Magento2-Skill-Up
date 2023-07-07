<?php

declare(strict_types=1);

namespace Test\StoreReviews\Block;

use Magento\Framework\View\Element\Template;
use Test\StoreReviews\Api\ReviewRepositoryInterface;
use Magento\Customer\Model\Session;

class Index extends Template
{
    private ReviewRepositoryInterface $reviewRepository;
    private Session $customerSession;

    public function __construct(
        Template\Context $context,
        ReviewRepositoryInterface $reviewRepository,
        Session $customerSession,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->reviewRepository = $reviewRepository;
        $this->customerSession = $customerSession;
    }

    public function getBaseUrl(): string
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getReviews(): array
    {
        return $this->reviewRepository->getList();
    }

    public function isLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

}
