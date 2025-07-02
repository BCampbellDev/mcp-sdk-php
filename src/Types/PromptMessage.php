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
 * Filename: Types/PromptMessage.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * PromptMessage
 * {
 *   role: Role;
 *   content: TextContent | ImageContent | AudioContent | EmbeddedResource;
 * }
 */
class PromptMessage implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $role;
    /**
     * @readonly
     * @var \Mcp\Types\TextContent|\Mcp\Types\ImageContent|\Mcp\Types\AudioContent|\Mcp\Types\EmbeddedResource
     */
    public $content;
    use ExtraFieldsTrait;

    /**
     * @param \Mcp\Types\TextContent|\Mcp\Types\ImageContent|\Mcp\Types\AudioContent|\Mcp\Types\EmbeddedResource $content
     * @param \Mcp\Types\Role::* $role
     */
    public function __construct($role, $content)
    {
        $this->role = $role;
        $this->content = $content;
    }

    public static function fromArray(array $data): self {
        $roleStr = $data['role'] ?? '';
        $role = Role::from($roleStr);

        unset($data['role']);

        $contentData = $data['content'] ?? [];
        unset($data['content']);

        if (!is_array($contentData) || !isset($contentData['type'])) {
            throw new \InvalidArgumentException("Invalid or missing content type in PromptMessage");
        }

        $contentType = $contentData['type'];
        switch ($contentType) {
            case 'text':
                $content = TextContent::fromArray($contentData);
                break;
            case 'image':
                $content = ImageContent::fromArray($contentData);
                break;
            case 'audio':
                $content = AudioContent::fromArray($contentData);
                break;
            case 'resource':
                $content = EmbeddedResource::fromArray($contentData);
                break;
            default:
                throw new \InvalidArgumentException("Unknown content type: $contentType");
        }

        $obj = new self($role, $content);

        foreach ($data as $k => $v) {
            $obj->$k = $v;
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        $this->content->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        return array_merge([
            'role' => $this->role,
            'content' => $this->content,
        ], $this->extraFields);
    }
}