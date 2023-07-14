<?php

declare(strict_types=1);

namespace Test\QuickView\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class AddToCart implements HttpPostActionInterface, HttpGetActionInterface
{
    private \Magento\Checkout\Model\SessionFactory $checkoutSession;
    private \Magento\Quote\Api\CartRepositoryInterface $cartRepository;
    private \Magento\Catalog\Api\ProductRepositoryInterface $productRepository;
    private \Magento\Framework\Serialize\Serializer\Json $json;
    private \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurableType;
    private \Magento\Framework\App\RequestInterface $request;
    private RedirectFactory $redirectFactory;

    /**
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     * @param \Magento\Checkout\Model\SessionFactory $checkoutSession
     * @param \Magento\Quote\Api\CartRepositoryInterface $cartRepository
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurableType
     * @param \Magento\Framework\App\RequestInterface $request
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Checkout\Model\SessionFactory $checkoutSession,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurableType,
        \Magento\Framework\App\RequestInterface $request,
        RedirectFactory $redirectFactory
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->json = $json;
        $this->configurableType = $configurableType;
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
    }

    public function execute()
    {
        $product = $this->productRepository->get($this->request->getParam('sku'));
        $qty = $this->request->getParam('qty');

        $session = $this->checkoutSession->create();
        $quote = $session->getQuote();
        $quote->addProduct($product, $qty);

        $this->cartRepository->save($quote);
        $session->replaceQuote($quote)->unsLastRealOrderId();

        $redirect = $this->redirectFactory->create();
        $redirect->setPath('checkout', ['_fragment' => 'payment']);

        return $redirect;
    }

}
