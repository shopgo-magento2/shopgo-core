<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Core\Helper;

use ShopGo\Core\Model\Logger\Handler\Base as LoggerHandlerBase;
use Monolog\Logger;

abstract class AbstractHelper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Add a log record
     *
     * @param int|string $level
     * @param mixed $message
     * @param array $context
     * @param resource|string $stream
     * @return bool
     */
    public function log($level, $message, array $context = [], $stream = '')
    {
        if (gettype($level) == 'string') {
            $loggerLevels = Logger::getLevels();
            $level = strtoupper($level);
            $level = isset($loggerLevels[$level])
                ? $loggerLevels[$level]
                : Logger::DEBUG;
        }

        if (gettype($message) == 'array' || gettype($message) == 'object') {
            $message = print_r($message, true);
        }

        if ($this->logger instanceOf \ShopGo\Core\Model\Logger\Monolog) {
            if ($stream) {
                $stream = BP . LoggerHandlerBase::BASE_DIR . $stream;
            }

            $result = $this->logger->addRecord($level, $message, $context, $stream);
        } else {
            $result = $this->logger->addRecord($level, $message, $context);
        }

        return $result;
    }
}
