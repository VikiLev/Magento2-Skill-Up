<?php

declare(strict_types=1);

namespace Test\Grid\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Test\Grid\Model\Grid;
use Test\Grid\Model\GridFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save CMS page action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Test_Grid::save';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    private GridFactory $gridModel;

    private \Test\Grid\Model\ResourceModel\Grid $gridResourceModel;

    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        GridFactory $gridModel,
        \Test\Grid\Model\ResourceModel\Grid $gridResourceModel
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->gridResourceModel = $gridResourceModel;
        $this->gridModel = $gridModel;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
//            $data = $this->dataProcessor->filter($data);
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Grid::STATUS_ENABLED;
            }
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var Grid $model */
            $model = $this->gridModel->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                $this->gridResourceModel->load($model, $id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                    /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            }

//            $data['layout_update_xml'] = $model->getLayoutUpdateXml();
//            $data['custom_layout_update_xml'] = $model->getCustomLayoutUpdateXml();
            $model->setData($data);

            try {
                $this->_eventManager->dispatch(
                    'test_grid_prepare_save',
                    ['page' => $model, 'request' => $this->getRequest()]
                );

                $this->gridResourceModel->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the page.'));
                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the page.'));
            }

            $this->dataPersistor->set('test_grid', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param Grid $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {

        $this->dataPersistor->clear('test_grid');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
