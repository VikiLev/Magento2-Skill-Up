<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Grid\Model;

use Magento\Framework\Model\AbstractModel;

class Grid extends AbstractModel
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'test_table_grid';

    protected function _construct()
    {
        $this->_init(\Test\Grid\Model\ResourceModel\Grid::class);
    }
}
