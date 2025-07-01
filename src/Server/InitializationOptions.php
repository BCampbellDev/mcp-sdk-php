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
 * Filename: Server/InitializationOptions.php
 */

declare(strict_types=1);

namespace Mcp\Server;

use Mcp\Types\McpModel;
use Mcp\Types\ServerCapabilities;
use Mcp\Types\ExtraFieldsTrait;
use InvalidArgumentException;

/**
 * Options used to initialize an MCP server
 */
class InitializationOptions implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $serverName;
    /**
     * @readonly
     * @var string
     */
    public $serverVersion;
    /**
     * @readonly
     * @var \Mcp\Types\ServerCapabilities
     */
    public $capabilities;
    use ExtraFieldsTrait;

    public function __construct(string $serverName, string $serverVersion, ServerCapabilities $capabilities)
    {
        $this->serverName = $serverName;
        $this->serverVersion = $serverVersion;
        $this->capabilities = $capabilities;
    }

    public function validate(): void {
        if (empty($this->serverName)) {
            throw new \InvalidArgumentException('Server name cannot be empty');
        }
        if (empty($this->serverVersion)) {
            throw new \InvalidArgumentException('Server version cannot be empty');
        }
        $this->capabilities->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'server_name' => $this->serverName,
            'server_version' => $this->serverVersion,
            'capabilities' => $this->capabilities,
        ];
        return array_merge($data, $this->extraFields);
    }
}