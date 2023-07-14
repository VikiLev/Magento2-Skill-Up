<?php

namespace Test\QuickView\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;
class QuickView extends Template
{
    protected Product $product;

    public function __construct(
        Template\Context $context,
        Product $product,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->product = $product;
    }
    /**
     * @return string
     */
    public function getProductSku()
    {
        $currentProduct = $this->product;

        return $currentProduct !== null ? $currentProduct->getSku() : "";
    }
    /**
     * @param $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}
