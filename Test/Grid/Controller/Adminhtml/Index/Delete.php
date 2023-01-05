<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Test\Grid\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Test\Grid\Model\GridFactory;

class Delete extends Action implements HttpPostActionInterface
{

    private GridFactory $gridModel;
    private \Test\Grid\Model\ResourceModel\Grid $gridResourceModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Test\Grid\Model\GridFactory $gridModel,
        \Test\Grid\Model\ResourceModel\Grid $gridResourceModel

    ){
        parent::__construct($context);
        $this->gridModel = $gridModel;
        $this->gridResourceModel = $gridResourceModel;
    }


    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->gridModel->create();
                $this->gridResourceModel->load($model, $id);
                $this->gridResourceModel->delete($model);
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the block.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a block to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
