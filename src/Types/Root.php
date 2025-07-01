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
 * Filename: Types/Root.php
 */

declare(strict_types=1);

namespace Mcp\Types;

class Root implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $uri;
    /**
     * @var string|null
     */
    public $name;
    use ExtraFieldsTrait;

    public function __construct(string $uri, ?string $name = null)
    {
        $this->uri = $uri;
        $this->name = $name;
    }

    public static function fromArray(array $data): self {
        $uri = $data['uri'] ?? '';
        $name = $data['name'] ?? null;
        unset($data['uri'], $data['name']);

        $obj = new self($uri, $name);

        foreach ($data as $k => $v) {
            $obj->$k = $v; // Root uses ExtraFieldsTrait
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        if (empty($this->uri)) {
            throw new \InvalidArgumentException('Root URI cannot be empty');
        }
        if (strncmp($this->uri, 'file://', strlen('file://')) !== 0) {
            throw new \InvalidArgumentException('Root URI must start with file://');
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = ['uri' => $this->uri];
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        return array_merge($data, $this->extraFields);
    }
}