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
 * - ChatGPT o1 pro mode
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
 * Filename: Types/Implementation.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Describes the name and version of an MCP implementation
 */
class Implementation implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $name;
    /**
     * @readonly
     * @var string
     */
    public $version;
    use ExtraFieldsTrait;

    public function __construct(string $name, string $version)
    {
        $this->name = $name;
        $this->version = $version;
    }

    public static function fromArray(array $data): self {
        // Extract required fields
        $name = $data['name'] ?? '';
        $version = $data['version'] ?? '';

        // Remove known fields from the array
        unset($data['name'], $data['version']);

        // Create the object
        $obj = new self($name, $version);

        // Assign leftover fields to extraFields
        foreach ($data as $k => $v) {
            $obj->$k = $v;
        }

        // Validate
        $obj->validate();

        return $obj;
    }

    public function validate(): void {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Implementation name cannot be empty');
        }
        if (empty($this->version)) {
            throw new \InvalidArgumentException('Implementation version cannot be empty');
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = get_object_vars($this);
        return array_merge($data, $this->extraFields);
    }
}