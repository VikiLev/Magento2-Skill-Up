<?php

declare(strict_types=1);

namespace Test\Plugins\Plugin\Model;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\PageRepository;

class AddMetaDataBeforePlugin
{
    /**
     * @param PageRepository $subject
     * @param PageInterface $page
     * @return PageInterface[]
     */
    public function beforeSave(PageRepository $subject, PageInterface $page): array
    {
        $page->setMetaTitle($page->getTitle());
        $page->setMetaKeywords($page->getTitle());
        $page->setMetaDescription($page->getTitle());

        return [$page];
    }
}
