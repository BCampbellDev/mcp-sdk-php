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
 * Filename: Types/CreateMessageResult.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Result of a create message request
 * content: TextContent | ImageContent
 */
class CreateMessageResult extends Result {
    /**
     * @readonly
     * @var \Mcp\Types\TextContent|\Mcp\Types\ImageContent
     */
    public $content;
    /**
     * @readonly
     * @var string
     */
    public $model;
    /**
     * @readonly
     * @var \Mcp\Types\Role
     */
    public $role;
    /**
     * @var string|null
     */
    public $stopReason;
    /**
     * @param \Mcp\Types\TextContent|\Mcp\Types\ImageContent $content
     * @param \Mcp\Types\Role::* $role
     */
    public function __construct(
        $content,
        string $model,
        $role,
        ?string $stopReason = null,
        ?Meta $_meta = null
    ) {
        $this->content = $content;
        $this->model = $model;
        $this->role = $role;
        $this->stopReason = $stopReason;
        parent::__construct($_meta);
    }

    public static function fromResponseData(array $data): self {
        // _meta
        $meta = null;
        if (isset($data['_meta'])) {
            $metaData = $data['_meta'];
            unset($data['_meta']);
            $meta = new Meta();
            foreach ($metaData as $k => $v) {
                $meta->$k = $v;
            }
        }

        // Extract known fields
        $model = $data['model'] ?? '';
        $roleStr = $data['role'] ?? '';
        $stopReason = $data['stopReason'] ?? null;
        $contentData = $data['content'] ?? [];
        unset($data['model'], $data['role'], $data['stopReason'], $data['content']);

        $role = Role::tryFrom($roleStr);
        if ($role === null) {
            throw new \InvalidArgumentException("Invalid role: $roleStr in CreateMessageResult");
        }

        if (!is_array($contentData) || !isset($contentData['type'])) {
            throw new \InvalidArgumentException('Invalid content data in CreateMessageResult');
        }

        $type = $contentData['type'];
        switch ($type) {
            case 'text':
                $content = TextContent::fromArray($contentData);
                break;
            case 'image':
                $content = ImageContent::fromArray($contentData);
                break;
            default:
                throw new \InvalidArgumentException("Unknown content type: $type in CreateMessageResult");
        }

        $obj = new self($content, $model, $role, $stopReason, $meta);

        // Extra fields
        foreach ($data as $k => $v) {
            $obj->$k = $v;
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        parent::validate();
        $this->content->validate();
        if (empty($this->model)) {
            throw new \InvalidArgumentException('Model name cannot be empty');
        }
        // role is an enum, no validation needed unless empty check wanted
    }
}