<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Grid\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

/**
 * Edit Grid page action.
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Test_Grid::post';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */


    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    private \Test\Grid\Model\GridFactory $gridModel;
    private \Test\Grid\Model\ResourceModel\Grid $gridResourceModel;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Test\Grid\Model\GridFactory $gridModel,
        \Test\Grid\Model\ResourceModel\Grid $gridResourceModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->gridModel = $gridModel;
        $this->gridResourceModel = $gridResourceModel;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Test_Grid::post')
            ->addBreadcrumb(__('Grid'), __('Grid'))
            ->addBreadcrumb(__('Manage Pages'), __('Manage Pages'));
        return $resultPage;
    }

    /**
     * Edit Grid page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = $this->gridModel->create();

        // 2. Initial checking
        if ($id) {
            $this->gridResourceModel->load($model, $id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Page') : __('New Page'),
            $id ? __('Edit Page') : __('New Page')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Pages'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Page'));

        return $resultPage;
    }
}
