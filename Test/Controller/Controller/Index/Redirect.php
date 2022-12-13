<?php

declare(strict_types=1);

namespace Test\Controller\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class Redirect implements HttpGetActionInterface
{
    private PageFactory $resultPageFactory;
    private RedirectFactory $redirectFactory;

    /**
     * @param PageFactory $resultPageFactory
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        PageFactory $resultPageFactory,
        RedirectFactory $redirectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute()
    {
        $redirect = $this->redirectFactory->create();
        $redirect->setPath('/');
        return $redirect;
    }
}
