<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class MonologLogger {

    private static $logger;

    public static function getLogger(): Logger {
        if (!self::$logger) {
            self::$logger = new Logger('MonologLogger');
            $logPath = self::$logger->get('monolog.logger.my_channel');;
            $streamHandler = new StreamHandler($logPath, Logger::DEBUG);
            self::$logger->pushHandler($streamHandler);
        }
        return self::$logger;
    }

    public static function debug($message, $context = array()) {
        self::getLogger()->debug($message, $context);
    }

    public static function info($message, $context = array()) {
        self::getLogger()->info($message, $context);
    }

    public static function warning($message, $context = array()) {
        self::getLogger()->warning($message, $context);
    }

    public static function error($message, $context = array()) {
        self::getLogger()->error($message, $context);
    }
}