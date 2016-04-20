<?php
/**
 * Copyright © 2015 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShopGo\Core\Model\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Monolog extends Logger
{
    /**
     * Adds a log record
     *
     * @param int $level
     * @param string $message
     * @param array $context
     * @param resource|string $stream
     * @return bool
     */
    public function addRecord($level, $message, array $context = [], $stream = 'php://stderr')
    {
        $context['is_exception'] = $message instanceof \Exception;

        if (!$this->handlers || $stream) {
            $this->pushHandler(new StreamHandler($stream, static::DEBUG));
        }

        $levelName = static::getLevelName($level);

        // check if any handler will handle this message so we can return early and save cycles
        $handlerKey = null;
        foreach ($this->handlers as $key => $handler) {
            if ($handler->isHandling(['level' => $level])) {
                $handlerKey = $key;
                break;
            }
        }

        if (null === $handlerKey) {
            return false;
        }

        if (!static::$timezone) {
            static::$timezone = new \DateTimeZone(date_default_timezone_get() ?: 'UTC');
        }

        $record = [
            'message' => (string) $message,
            'context' => $context,
            'level' => $level,
            'level_name' => $levelName,
            'channel' => $this->name,
            'datetime' => \DateTime::createFromFormat(
                'U.u',
                sprintf(
                    '%.6F',
                    microtime(true)), static::$timezone
                )->setTimezone(static::$timezone),
            'extra' => [],
        ];

        foreach ($this->processors as $processor) {
            $record = call_user_func($processor, $record);
        }
        while (isset($this->handlers[$handlerKey]) &&
            false === $this->handlers[$handlerKey]->handle($record)) {
            $handlerKey++;
        }

        return true;
    }
}
