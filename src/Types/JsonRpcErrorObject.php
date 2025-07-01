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
 * Filename: Types/JsonRpcErrorObject.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Represents the error object for JSON-RPC errors:
 * { code: number; message: string; data?: unknown }
 */
class JsonRpcErrorObject implements McpModel {
    /**
     * @readonly
     * @var int
     */
    public $code;
    /**
     * @readonly
     * @var string
     */
    public $message;
    /**
     * @readonly
     * @var mixed
     */
    public $data = null;
    use ExtraFieldsTrait;

    /**
     * @param mixed $data
     */
    public function __construct(int $code, string $message, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function validate(): void {
        // code must be integer, message must be string and non-empty
        if ($this->message === '') {
            throw new \InvalidArgumentException('Error message cannot be empty');
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'code' => $this->code,
            'message' => $this->message,
        ];
        if ($this->data !== null) {
            $data['data'] = $this->data;
        }
        return array_merge($data, $this->extraFields);
    }
}