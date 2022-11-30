<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\PlayModels\Model;

use Magento\Framework\Model\AbstractModel;

class Card extends AbstractModel
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'test_card';

    protected function _construct()
    {
        $this->_init(\Test\PlayModels\Model\ResourceModel\Card::class);
    }
}
