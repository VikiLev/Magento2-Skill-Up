<?php

declare(strict_types=1);

namespace Test\StoreReviews\Controller\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Test\StoreReviews\Model\ReviewRepository;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Message\ManagerInterface;

class Result implements HttpPostActionInterface
{
    private JsonFactory $jsonFactory;
    private RequestInterface $request;
    private ReviewRepository $repository;
    private Validator $validator;
    private ManagerInterface $messageManager;

    /**
     * @param JsonFactory $jsonFactory
     * @param RequestInterface $request
     * @param ReviewRepository $repository
     * @param Validator $validator
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        JsonFactory $jsonFactory,
        RequestInterface $request,
        ReviewRepository $repository,
        Validator $validator,
        ManagerInterface $messageManager
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $title = (string) $this->request->getParam('title');
        $review = (string) $this->request->getParam('review');
        $pros = (string) $this->request->getParam('pros');
        $cons = (string) $this->request->getParam('cons');

        $jsonResult = $this->jsonFactory->create();
        $jsonResult->setData(['title'=> $title, 'review'=> $review,'pros'=> $pros,'cons'=> $cons]);

        $reviewModel = $this->repository->getReview();

        if (!$this->validator->validate($this->request)
            && !$title
            && !$review
            && !$pros
            && !$cons
        ) {
            $this->messageManager->addNoticeMessage(__("review is empty"));
        } else {
            $reviewModel->setTitle($title);
            $reviewModel->setReview($review);
            $reviewModel->setPros($pros);
            $reviewModel->setCons($cons);
            $this->repository->save($reviewModel);
        }

        return  $jsonResult;
    }
}
