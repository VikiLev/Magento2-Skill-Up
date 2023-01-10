<?php

declare(strict_types=1);

namespace Test\FreeShipping\ViewModel;

use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Http\Context;

class ViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    const XML_Free_SHIPPING = 'carriers/freeshipping/free_shipping_subtotal';

    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    private \Magento\Catalog\Api\ProductRepositoryInterface $productRepository;

    private \Magento\Framework\App\RequestInterface $request;
    private \Magento\Catalog\Api\ProductRenderListInterface $productRenderList;

    private \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    private \Magento\Framework\App\Http\Context $httpContext;

    private \Magento\Store\Api\StoreRepositoryInterface $storeRepository;

    private \Magento\Checkout\Model\Session $checkoutSession;

    private \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Catalog\Api\ProductRenderListInterface $productRenderList
     * @param Context $httpContext
     * @param \Magento\Store\Api\StoreRepositoryInterface $storeRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Catalog\Api\ProductRenderListInterface $productRenderList,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->productRenderList = $productRenderList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->httpContext = $httpContext;
        $this->storeRepository = $storeRepository;
        $this->checkoutSession = $checkoutSession;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @return bool
     */
    public function hasFreeShipping(): bool
    {
        $freeShippingSubtotal = $this->getFreeShippingSubtotal();
        return $freeShippingSubtotal <= $this->getProductPrice();
    }

    /**
     * @return mixed
     */
    private function getFreeShippingSubtotal(): mixed
    {
        return $this->scopeConfig->getValue(self::XML_Free_SHIPPING, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return float|null
     */
    private function getProductPrice(): ?float
    {
        $productId = $this->request->getParam('id');
        $product =  $this->productRepository->getById($productId);
        $finalProductPrice = $product->getPrice();

//        return $product->getFinalPrice();
//        $productPrice = $product->getPriceInfo()->getPrice('final_price');

        $searchCriteria = $this->searchCriteriaBuilder->addFilter('entity_id', $productId)->create();
        $storeCode = $this->httpContext->getValue(StoreManagerInterface::CONTEXT_STORE);
        $currencyCode = $this->httpContext->getValue(Context::CONTEXT_CURRENCY);
        $storeId = $this->storeRepository->getActiveStoreById($storeCode)->getId();

        $results = $this->productRenderList->getList($searchCriteria, $storeId, $currencyCode);

        foreach ($results->getItems() as $productRender) {
            $finalProductPrice = $productRender->getPriceInfo()->getFinalPrice();
            break;
        }

        return $finalProductPrice;
    }

    /**
     * @return string
     */
    public function getLeftFreeShipping(): string
    {
        $freeShippingSubtotal = $this->getFreeShippingSubtotal();
        return $this->priceCurrency->format($freeShippingSubtotal - $this->getQuoteSubtotal());

    }

    /**
     * @return float
     */
    public function getQuoteSubtotal(): float
    {
        $quote = $this->checkoutSession->getQuote();
        return $quote->getSubtotal();
    }

    /**
     * @return bool
     */
    public function hasFreeShippingQuote(): bool
    {
        $freeShippingSubtotal = $this->getFreeShippingSubtotal();
        return $freeShippingSubtotal <= $this->getQuoteSubtotal();
    }
}
