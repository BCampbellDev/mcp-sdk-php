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
 * Filename: Types/LoggingMessageNotificationParams.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Params for LoggingMessageNotification
 * {
 *   level: LoggingLevel;
 *   logger?: string;
 *   data: unknown;
 * }
 */
class LoggingMessageNotificationParams implements McpModel {
    /**
     * @readonly
     * @var \Mcp\Types\LoggingLevel
     */
    public $level;
    /**
     * @readonly
     * @var mixed
     */
    public $data;
    /**
     * @var string|null
     */
    public $logger;
    use ExtraFieldsTrait;

    /**
     * @param mixed $data
     * @param \Mcp\Types\LoggingLevel::* $level
     */
    public function __construct($level, $data, ?string $logger = null)
    {
        $this->level = $level;
        $this->data = $data;
        $this->logger = $logger;
    }

    public function validate(): void {
        if ($this->data === null) {
            throw new \InvalidArgumentException('Logging message data cannot be null');
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'level' => $this->level->value,
            'data' => $this->data,
        ];
        if ($this->logger !== null) {
            $data['logger'] = $this->logger;
        }
        return array_merge($data, $this->extraFields);
    }
}