<?php

namespace Test\PlayModels\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * CMS block model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Card extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('test_table', 'entity_id');
    }
}
