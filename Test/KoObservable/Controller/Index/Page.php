<?php

declare(strict_types=1);

namespace Test\KoObservable\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Page implements HttpGetActionInterface
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
        return $this->resultPageFactory->create();
    }
}
