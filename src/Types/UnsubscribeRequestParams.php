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
 * Filename: Types/UnsubscribeRequestParams.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Params for UnsubscribeRequest:
 * { uri: string }
 */
class UnsubscribeRequestParams implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $uri;
    use ExtraFieldsTrait;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    public function validate(): void {
        if (empty($this->uri)) {
            throw new \InvalidArgumentException('Resource URI cannot be empty');
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        return array_merge(['uri' => $this->uri], $this->extraFields);
    }
}