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
 * Filename: Types/Resource.php
 */

declare(strict_types=1);

namespace Mcp\Types;

class Resource implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $name;
    /**
     * @readonly
     * @var string
     */
    public $uri;
    /**
     * @var string|null
     */
    public $description;
    /**
     * @var string|null
     */
    public $mimeType;
    use ExtraFieldsTrait;
    use AnnotatedTrait;

    public function __construct(
        string $name,
        string $uri,
        ?string $description = null,
        ?string $mimeType = null,
        ?Annotations $annotations = null
    ) {
        $this->name = $name;
        $this->uri = $uri;
        $this->description = $description;
        $this->mimeType = $mimeType;
        $this->annotations = $annotations;
    }

    public static function fromArray(array $data): self {
        $name = $data['name'] ?? '';
        $uri = $data['uri'] ?? '';
        $description = $data['description'] ?? null;
        $mimeType = $data['mimeType'] ?? null;

        unset($data['name'], $data['uri'], $data['description'], $data['mimeType']);

        $annotations = null;
        if (isset($data['annotations']) && is_array($data['annotations'])) {
            $annotations = Annotations::fromArray($data['annotations']);
            unset($data['annotations']);
        }

        $obj = new self($name, $uri, $description, $mimeType, $annotations);

        foreach ($data as $k => $v) {
            $obj->$k = $v;
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Resource name cannot be empty');
        }
        if (empty($this->uri)) {
            throw new \InvalidArgumentException('Resource URI cannot be empty');
        }
        $this->validateAnnotations();
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'name' => $this->name,
            'uri' => $this->uri,
        ];
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }
        if ($this->mimeType !== null) {
            $data['mimeType'] = $this->mimeType;
        }
        return array_merge($data, $this->annotationsToJson(), $this->extraFields);
    }
}