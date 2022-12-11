<?php

namespace Test\Test\Plugin;

use Magento\Framework\App\RequestInterface;

class CustomerExtractor
{
    /**
     * @param \Magento\Customer\Model\Metadata\Form $subject
     * @param RequestInterface $request
     * @param string|null $scope
     * @param bool $scopeOnly
     * @return array
     */
    public function beforeExtractData(\Magento\Customer\Model\Metadata\Form $subject, RequestInterface $request, $scope = null, $scopeOnly = true)
    {
        if(stristr($request->getParam('firstname')," ")) {
            $firstname = str_replace(" ", '', $request->getParam('firstname'));
            $request->setParam('firstname', $firstname);
        }

        return [$request, $scope, $scopeOnly];
    }
}
