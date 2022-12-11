<?php

namespace Test\Test\Logger;

use Magento\Framework\Logger\Handler\Base as BaseHandler;

class Handler extends BaseHandler
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = CustomerLogger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/customer.log';
}
