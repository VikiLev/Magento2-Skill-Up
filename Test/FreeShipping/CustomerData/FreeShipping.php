<?php

declare(strict_types=1);

namespace Test\FreeShipping\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Store\Model\ScopeInterface;

class FreeShipping implements SectionSourceInterface
{
    const XML_Free_SHIPPING = 'carriers/freeshipping/free_shipping_subtotal';

    private \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    private \Magento\Checkout\Model\Session $checkoutSession;

    private \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * /**
     * @return array
     */
    public function getSectionData(): array
    {
        $freeShippingSubtotal = $this->getFreeShippingSubtotal();
        $subtotalQuote = $this->getQuoteSubtotal();
        return [
            'hasFreeShippingQuote' => $freeShippingSubtotal <= $subtotalQuote,
            'getLeftFreeShipping' => $this->priceCurrency->format($freeShippingSubtotal - $this->getQuoteSubtotal())
        ];
    }

    /**
     * @return float
     */
    public function getQuoteSubtotal(): float
    {
        $quote = $this->checkoutSession->getQuote();
        return (float) $quote->getSubtotal();
    }

    /**
     * @return mixed
     */
    private function getFreeShippingSubtotal(): mixed
    {
        return $this->scopeConfig->getValue(self::XML_Free_SHIPPING, ScopeInterface::SCOPE_STORE);
    }
}
