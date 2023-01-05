<?php

namespace Test\Grid\Ui\Component\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Test\Grid\Model\ResourceModel\Grid\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    private CollectionFactory $collectionFactory;

    private DataPersistorInterface $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $data = $this->dataPersistor->get('test_grid');

        if (!empty($data)) {
            $gridModel = $this->collection->getNewEmptyItem();
            $gridModel->setData($data);
            $this->loadedData[$gridModel->getId()] = $gridModel->getData();
            $this->dataPersistor->clear('test_grid');
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        /** @var \Test\Grid\Model\Grid $gridModel*/
        foreach ($items as $gridModel) {
            $this->loadedData[$gridModel->getId()] = $gridModel->getData();
        }

        return $this->loadedData;
    }
}
