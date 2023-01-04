<?php

namespace Test\Grid\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Test_Grid::post';

    private PageFactory $resultPageFactory;

   public function __construct(
       Context $context,
       PageFactory $resultPageFactory
   ) {
       parent::__construct($context);
       $this->resultPageFactory = $resultPageFactory;
   }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Test_Grid::post');
        $resultPage->addBreadcrumb(__('GRID'), __('GRID'));
        $resultPage->addBreadcrumb(__('Manage GRID'), __('Manage GRID'));
        $resultPage->getConfig()->getTitle()->prepend(__('Grid'));

//        $this->dataPersistor->clear('cms_page');

        return $resultPage;
    }
}
