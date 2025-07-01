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
 * Filename: Shared/Progress.php
 */

declare(strict_types=1);

namespace Mcp\Shared;

use Mcp\Types\McpModel;
use Mcp\Types\ExtraFieldsTrait;
use InvalidArgumentException;

/**
 * Progress information model
 *
 * Equivalent to the Python Progress(BaseModel) class.
 */
class Progress implements McpModel {
    /**
     * @readonly
     * @var float
     */
    public $progress;
    /**
     * @readonly
     * @var float|null
     */
    public $total;
    use ExtraFieldsTrait;

    public function __construct(float $progress, ?float $total = null)
    {
        $this->progress = $progress;
        $this->total = $total;
    }

    public function validate(): void {
        if ($this->total !== null && $this->total < $this->progress) {
            throw new InvalidArgumentException('Total cannot be less than progress');
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = [
            'progress' => $this->progress,
        ];
        if ($this->total !== null) {
            $data['total'] = $this->total;
        }
        return array_merge($data, $this->extraFields);
    }
}