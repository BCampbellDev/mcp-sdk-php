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
 * Filename: Types/SamplingMessage.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * SamplingMessage
 * {
 *   role: Role,
 *   content: TextContent | ImageContent
 * }
 */
class SamplingMessage implements McpModel {
    /**
     * @readonly
     * @var \Mcp\Types\Role
     */
    public $role;
    /**
     * @readonly
     * @var \Mcp\Types\TextContent|\Mcp\Types\ImageContent
     */
    public $content;
    use ExtraFieldsTrait;

    /**
     * @param \Mcp\Types\TextContent|\Mcp\Types\ImageContent $content
     * @param \Mcp\Types\Role::* $role
     */
    public function __construct($role, $content)
    {
        $this->role = $role;
        $this->content = $content;
    }

    public function validate(): void {
        $this->content->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        return array_merge([
            'role' => $this->role->value,
            'content' => $this->content,
        ], $this->extraFields);
    }
}