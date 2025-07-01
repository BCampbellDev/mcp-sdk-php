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
 * Filename: Types/JsonRpcMessage.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * JSON-RPC message is a union of:
 * - JSONRPCRequest
 * - JSONRPCNotification
 * - JSONRPCResponse
 * - JSONRPCError
 * - JSONRPCBatchRequest
 * - JSONRPCBatchResponse
 *
 * This class acts as a RootModel for that union.
 */
class JsonRpcMessage implements McpModel {
    /**
     * @readonly
     * @var \Mcp\Types\JSONRPCRequest|\Mcp\Types\JSONRPCNotification|\Mcp\Types\JSONRPCResponse|\Mcp\Types\JSONRPCError|\Mcp\Types\JSONRPCBatchRequest|\Mcp\Types\JSONRPCBatchResponse
     */
    public $message;
    use ExtraFieldsTrait;

    /**
     * We store one of the four possible variants.
     * @param \Mcp\Types\JSONRPCRequest|\Mcp\Types\JSONRPCNotification|\Mcp\Types\JSONRPCResponse|\Mcp\Types\JSONRPCError|\Mcp\Types\JSONRPCBatchRequest|\Mcp\Types\JSONRPCBatchResponse $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function validate(): void {
        $this->message->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        // Just serialize the underlying message variant.
        $data = $this->message->jsonSerialize();

        // Merge any extra fields set directly on JsonRpcMessage (rare)
        return array_merge((array)$data, $this->extraFields);
    }

}