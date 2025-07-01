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
 * Filename: Types/CompletionArgument.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Represents the argument object in CompleteRequest.params.argument
 * {
 *   name: string,
 *   value: string
 * }
 */
class CompletionArgument implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $name;
    /**
     * @readonly
     * @var string
     */
    public $value;
    use ExtraFieldsTrait;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function validate(): void {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Completion argument name cannot be empty');
        }
        if (empty($this->value)) {
            throw new \InvalidArgumentException('Completion argument value cannot be empty');
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