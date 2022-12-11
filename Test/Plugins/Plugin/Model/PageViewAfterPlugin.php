<?php

declare(strict_types=1);

namespace Test\Plugins\Plugin\Model;

use Magento\Cms\Model\ResourceModel\Page;
use Magento\Framework\Model\AbstractModel;

class PageViewAfterPlugin
{
    /**
     * @param Page $subject
     * @param Page $result
     * @param AbstractModel $object
     * @param $value
     * @param $field
     * @return Page
     */
    public function afterLoad(Page $subject, Page $result, AbstractModel $object, $value, $field = null): Page
    {
        $object->setContent('<div style="color: red">' . __('Test'). '</div>');

        return $result;
    }
}
