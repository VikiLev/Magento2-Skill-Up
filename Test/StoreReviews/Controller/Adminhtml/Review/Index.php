<?php

declare(strict_types=1);

namespace Test\StoreReviews\Controller\Adminhtml\Review;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    private PageFactory $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Test_StoreReviews::all');
        $resultPage->getConfig()->getTitle()->prepend(__("Store Reviews"));
        return $resultPage;
    }
}
