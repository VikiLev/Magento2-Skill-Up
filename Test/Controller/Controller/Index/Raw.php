<?php

declare(strict_types=1);

namespace Test\Controller\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RawFactory;

class Raw implements  HttpGetActionInterface
{
    private RawFactory $resultRawFactory;

    /**
     * @param RawFactory $resultRawFactory
     */
    public function __construct(
        RawFactory $resultRawFactory
    ) {
        $this->resultRawFactory = $resultRawFactory;
    }

    public function execute()
    {
        $result = $this->resultRawFactory->create();
        // Response in xml format
        $content = '<product>
                        <productData>Test Raw Controller</productData>
                        <profileData>Test Raw Controllerl</profileData>
                    </product>';
        $result->setHeader('Content-Type', 'text/xml');
        $result->setContents($content);
        return $result;
    }
}
