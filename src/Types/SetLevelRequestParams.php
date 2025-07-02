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
 * Filename: Types/SetLevelRequestParams.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Params for SetLevelRequest:
 * { level: LoggingLevel }
 */
class SetLevelRequestParams extends \Mcp\Types\RequestParams implements McpModel {
    /**
     * @readonly
     * @var string
     */
    public $level;
    use ExtraFieldsTrait;

    public function __construct(string $level)
    {
        $this->level = $level;
    }

    public function validate(): void {
        // level is an enum, always valid
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        return array_merge(['level' => $this->level], $this->extraFields);
    }
}