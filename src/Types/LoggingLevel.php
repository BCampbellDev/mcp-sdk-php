<?php

/**
 * Model Context Protocol SDK for PHP
 *
 * (c) 2024 Logiscape LLC <https://logiscape.com>
 *
 * Based on the Python SDK for the Model Context Protocol
 * https://github.com/modelcontextprotocol/python-sdk
 *
 * PHP conversion developed by:
 * - Josh Abbott
 * - Claude 3.5 Sonnet (Anthropic AI model)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    logiscape/mcp-sdk-php
 * @author     Josh Abbott <https://joshabbott.com>
 * @copyright  Logiscape LLC
 * @license    MIT License
 * @link       https://github.com/logiscape/mcp-sdk-php
 *
 * Filename: Types/LoggingLevel.php
 */

declare(strict_types=1);

namespace Mcp\Types;

class LoggingLevel
{
    public const EMERGENCY = 'emergency';
    public const ALERT = 'alert';
    public const CRITICAL = 'critical';
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const NOTICE = 'notice';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    public static function from($level)
    {
        if (is_string($level)) {
            switch ($level) {
                case self::EMERGENCY:
                    return self::EMERGENCY;
                case self::ALERT:
                    return self::ALERT;
                case self::CRITICAL:
                    return self::CRITICAL;
                case self::ERROR:
                    return self::ERROR;
                case self::WARNING:
                    return self::WARNING;
                case self::NOTICE:
                    return self::NOTICE;
                case self::INFO:
                    return self::INFO;
                case self::DEBUG:
                    return self::DEBUG;
            }
        }

        throw new \InvalidArgumentException("Invalid logging level: $level");
    }
}