<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\Core\Helper;

class Utility extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \ShopGo\AdvancedConfig\Model\Config
     */
    protected $config;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \ShopGo\AdvancedLogger\Model\Logger $logger
     * @param \ShopGo\AdvancedConfig\Model\Config $config
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \ShopGo\AdvancedLogger\Model\Logger $logger,
        \ShopGo\AdvancedConfig\Model\Config $config
    ) {
        $this->logger = $logger;
        $this->config = $config;

        parent::__construct($context);
    }

    /**
     * Get logger
     *
     * @return \ShopGo\AdvancedLogger\Model\Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Get config
     *
     * @return \ShopGo\AdvancedConfig\Model\Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
