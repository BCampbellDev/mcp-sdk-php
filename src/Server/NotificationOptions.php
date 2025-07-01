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
 * Filename: Server/NotificationOptions.php
 */

declare(strict_types=1);

namespace Mcp\Server;

use RuntimeException;

/**
 * Options for server notifications
 */
class NotificationOptions {
    /**
     * @readonly
     * @var bool
     */
    public $promptsChanged = false;
    /**
     * @readonly
     * @var bool
     */
    public $resourcesChanged = false;
    /**
     * @readonly
     * @var bool
     */
    public $toolsChanged = false;
    public function __construct(bool $promptsChanged = false, bool $resourcesChanged = false, bool $toolsChanged = false)
    {
        $this->promptsChanged = $promptsChanged;
        $this->resourcesChanged = $resourcesChanged;
        $this->toolsChanged = $toolsChanged;
    }
}