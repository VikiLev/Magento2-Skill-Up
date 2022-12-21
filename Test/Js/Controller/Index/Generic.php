<?php

namespace Test\Js\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\LayoutFactory;

class Generic implements HttpGetActionInterface
{
    private LayoutFactory $resultLayoutFactory;

    /**
     * @param LayoutFactory $resultLayoutFactory
     */
    public function __construct(
        LayoutFactory $resultLayoutFactory
    ) {
        $this->resultLayoutFactory = $resultLayoutFactory;
    }

    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
