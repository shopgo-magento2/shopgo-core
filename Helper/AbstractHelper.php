<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Core\Helper;

use ShopGo\AdvancedLogger\Model\Logger;

abstract class AbstractHelper extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Log namespace directory path
     */
    const LOG_NAMESPACE_PATH = 'shopgo/';

    /**
     * Log module directory path
     */
    const LOG_MODULE_PATH = '';

    /**
     * @var Utility
     */
    protected $utility;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param Utility $utility
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Utility $utility
    ) {
        $this->utility = $utility;
        parent::__construct($context);
    }

    /**
     * Get logger
     *
     * @return \ShopGo\AdvancedLogger\Model\Logger
     */
    public function getLogger()
    {
        return $this->utility->getLogger();
    }

    /**
     * Get Monolog
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function getMonolog()
    {
        return $this->getLogger()->getMonolog();
    }

    /**
     * Get config model
     *
     * @return \ShopGo\AdvancedConfig\Model\Config
     */
    public function getConfig()
    {
        return $this->utility->getConfig();
    }

    /**
     * Add a log record
     *
     * @param int|string $level
     * @param mixed $message
     * @param array $context
     * @param string $file
     * @param array|string $path
     * @return bool
     */
    protected function _log($level, $message, array $context = [], $file = '', $path = null)
    {
        if (!$path) {
            $path = static::LOG_NAMESPACE_PATH . static::LOG_MODULE_PATH;
        } elseif (strpos($path, './') == 0) {
            $path = str_replace('./', '', $path);
            $path = static::LOG_NAMESPACE_PATH . static::LOG_MODULE_PATH . $path;
        }

        return $this->getLogger()->log($level, $message, $context, $file, $path);
    }
}
