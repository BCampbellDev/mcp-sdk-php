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
 * Filename: Types/JSONRPCError.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * A response indicating an error occurred.
 *
 * {
 *   "jsonrpc": "2.0",
 *   "id": string|number,
 *   "error": {
 *     "code": number,
 *     "message": string,
 *     "data"?: unknown
 *   }
 * }
 */
class JSONRPCError implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $jsonrpc;
    /**
     * @var \Mcp\Types\RequestId
     */
    public $id;
    /**
     * @var \Mcp\Types\JsonRpcErrorObject
     */
    public $error;
    use ExtraFieldsTrait;

    public function __construct(string $jsonrpc, RequestId $id, JsonRpcErrorObject $error)
    {
        $this->jsonrpc = $jsonrpc;
        $this->id = $id;
        $this->error = $error;
    }

    public function validate(): void {
        if ($this->jsonrpc !== '2.0') {
            throw new \InvalidArgumentException('JSON-RPC version must be "2.0"');
        }
        $this->id->validate();
        $this->error->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'jsonrpc' => $this->jsonrpc,
            'id' => $this->id,
            'error' => $this->error,
        ];
        return array_merge($data, $this->extraFields);
    }
}