<?php

declare(strict_types=1);

namespace Test\QuickView\Controller\Ajax;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Message\ManagerInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Result implements HttpGetActionInterface
{
    private JsonFactory $jsonFactory;
    private RequestInterface $request;
    private Validator $validator;
    private ManagerInterface $messageManager;
    private ProductRepositoryInterface $productRepository;

    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        JsonFactory $jsonFactory,
        RequestInterface $request,
        ProductRepositoryInterface $productRepository
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->productRepository = $productRepository;
    }

    public function execute()
    {
        $result = $this->jsonFactory->create();
        $product = $this->productRepository->get($this->request->getParam('sku'));

        return $result->setData(['success' => true,'product'=>\Zend_Json::encode($product)]);

    }
}
