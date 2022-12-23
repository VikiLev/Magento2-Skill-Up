<?php

declare(strict_types=1);

namespace Test\Checkout\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface
{
    public function process($jsLayout): array
    {
        if (!isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']
            ['before-shipping-method-form']['children']['checkoutComment'])
        ) {
            return $jsLayout;
        }

        if (!$this->canShowCheckoutComment()) {
            unset ($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']
                ['before-shipping-method-form']['children']['checkoutComment']);
        } else {
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['before-shipping-method-form']['children']['checkoutComment']['config']
            ['placeholder'] = $this->getCheckoutCommentPlaceholder();
        }

        return $jsLayout;
    }

    public function canShowCheckoutComment(): bool
    {
        return true;
    }

    public function getCheckoutCommentPlaceholder(): string
    {
        return 'Enter comment!!!';
    }
}
