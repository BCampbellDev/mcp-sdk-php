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
 * Filename: Types/Tool.php
 */

declare(strict_types=1);

namespace Mcp\Types;

class Tool implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $name;
    /**
     * @readonly
     * @var \Mcp\Types\ToolInputSchema
     */
    public $inputSchema;
    /**
     * @var string|null
     */
    public $description;
    /**
     * @var \Mcp\Types\ToolAnnotations|null
     */
    public $annotations;
    use ExtraFieldsTrait;

    public function __construct(string $name, ToolInputSchema $inputSchema, ?string $description = null, ?ToolAnnotations $annotations = null)
    {
        $this->name = $name;
        $this->inputSchema = $inputSchema;
        $this->description = $description;
        $this->annotations = $annotations;
    }

    public static function fromArray(array $data): self {
        $name = $data['name'] ?? '';
        $description = $data['description'] ?? null;
        $annotationsData = $data['annotations'] ?? null;
        $inputSchemaData = $data['inputSchema'] ?? [];
        unset($data['name'], $data['description'], $data['inputSchema'], $data['annotations']);

        $inputSchema = ToolInputSchema::fromArray($inputSchemaData);

        $annotations = null;
		// Properly cast annotations to ToolAnnotations object.
        if ($annotationsData !== null && is_array($annotationsData)) {
            $annotations = ToolAnnotations::fromArray($annotationsData);
        } elseif ($annotationsData instanceof ToolAnnotations) {
            $annotations = $annotationsData;
        }

        $obj = new self($name, $inputSchema, $description, $annotations);

        foreach ($data as $k => $v) {
            $obj->$k = $v; // Tool uses ExtraFieldsTrait
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Tool name cannot be empty');
        }
        // inputSchema must have type: "object"
        // We're enforcing type: "object" in ToolInputSchema jsonSerialize().
        // Just validate that inputSchema is valid and actually sets type object there.
        $this->inputSchema->validate();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'name' => $this->name,
            'inputSchema' => $this->inputSchema,
        ];
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }
        if ($this->annotations !== null) {
            $data['annotations'] = $this->annotations;
        }
        return array_merge($data, $this->extraFields);
    }
}