<?php

declare(strict_types=1);

namespace Test\KoObservable\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Dice implements HttpGetActionInterface
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
        $jsonFactory = $this->jsonFactory->create();
        $jsonFactory->setData(['diceNumber' => rand(1,6), 'canShow' => rand(0,1)]);
        return $jsonFactory;
    }
}
