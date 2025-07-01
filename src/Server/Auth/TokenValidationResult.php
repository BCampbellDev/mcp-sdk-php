<?php

/**
 * Model Context Protocol SDK for PHP
 *
 * (c) 2025 Logiscape LLC <https://logiscape.com>
 *
 * Developed by:
 * - Josh Abbott
 * - Claude Opus 4 (Anthropic AI model)
 * - OpenAI Codex
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
 * Filename: Server/Auth/TokenValidationResult.php
 */

declare(strict_types=1);

namespace Mcp\Server\Auth;

/**
 * Result of a token validation attempt.
 */
class TokenValidationResult
{
    /**
     * @var bool
     * @readonly
     */
    public $valid;
    /**
     * @var array<string, mixed>
     * @readonly
     */
    public $claims = [];
    /**
     * @var string|null
     * @readonly
     */
    public $error;
    /**
     * Constructor.
     *
     * @param bool $valid Whether the token was valid
     * @param array<string,mixed> $claims Token claims if valid
     * @param string|null $error Optional validation error message
     */
    public function __construct(bool $valid, array $claims = [], ?string $error = null)
    {
        $this->valid = $valid;
        $this->claims = $claims;
        $this->error = $error;
    }
}
