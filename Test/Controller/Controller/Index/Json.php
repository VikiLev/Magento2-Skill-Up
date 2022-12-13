<?php

declare(strict_types=1);

namespace Test\Controller\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Json implements HttpGetActionInterface
{
    private JsonFactory $jsonFactory;

    /**
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        JsonFactory $jsonFactory
    ) {
        $this->jsonFactory = $jsonFactory;
    }

    public function execute()
    {
        $jsonResult = $this->jsonFactory->create();
        $jsonResult->setData(['one'=> 1, 'two'=> 2]);
        return  $jsonResult;
    }
}
