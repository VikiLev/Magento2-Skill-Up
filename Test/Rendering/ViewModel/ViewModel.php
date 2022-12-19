<?php

namespace Test\Rendering\ViewModel;

use Magento\Framework\UrlInterface;

class ViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    private UrlInterface $url;

    public function __construct(UrlInterface $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->url->getBaseUrl();
    }
}
