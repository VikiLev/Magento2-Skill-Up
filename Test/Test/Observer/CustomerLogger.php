<?php

namespace Test\Test\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Test\Test\Logger\CustomerLogger as AddCustomerLogger;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;

class CustomerLogger implements ObserverInterface
{
    const XML_PATH_CUSTOMER_SUPPORT_EMAIL_ADDRESS = 'trans_email/ident_support/email';

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var AddCustomerLogger
     */
    protected $customerLogger;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ScopeConfigInterface $scopeConfig,
        AddCustomerLogger $customerLogger,
        LoggerInterface $logger
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->customerLogger = $customerLogger;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $customerData = [
            'firstname' => $customer->getFirstName(),
            'lastname' => $customer->getLastname(),
            'email' => $customer->getEmail(),
            'time' => $customer->getCreatedAt()
        ];

        try {
            $this->customerLogger->info("New Customer registered: ", $customerData);

        } catch (\Exception $e) {
            throw new CouldNotSaveException(__(
                'Could not save logs',
                $e->getMessage()
            ));
        }

        $this->inlineTranslation->suspend();

        try {
            $customerSupportEmail = $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_SUPPORT_EMAIL_ADDRESS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('email_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'firstname' => $customer->getFirstName(),
                    'lastname' => $customer->getLastname(),
                    'email' => $customer->getEmail()
                ])
                ->addTo($customerSupportEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
