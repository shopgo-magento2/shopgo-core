<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShopGo\Core\Model\Logger\Handler;

use Magento\Framework\Filesystem\DriverInterface;
use Monolog\Logger;

class Base extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Log base directory path
     */
    const BASE_DIR = '/var/log/shopgo/';

    /**
     * @param DriverInterface $filesystem
     * @param string $filePath
     * @param string $fileName
     * @param string $loggerType
     */
    public function __construct(
        DriverInterface $filesystem,
        $filePath = null,
        $fileName = '',
        $loggerType = ''
    ) {
        $loggerLevels = Logger::getLevels();
        $loggerType   = strtoupper($loggerType);

        if ($fileName) {
            $this->fileName = $fileName;
        }
        if (isset($loggerLevels[$loggerType])) {
            $this->loggerType = $loggerLevels[$loggerType];
        }

        $this->fileName = self::BASE_DIR . $this->fileName;

        parent::__construct($filesystem, $filePath);
    }
}
