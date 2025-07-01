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
 * Filename: Types/CreateMessageRequest.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Request to create a message via sampling
 */
class CreateMessageRequest extends Request {
    /**
     * @var SamplingMessage[]
     * @readonly
     */
    public $messages;
    /**
     * @readonly
     * @var int
     */
    public $maxTokens;
    /**
     * @var mixed[]|null
     */
    public $stopSequences;
    /**
     * @var string|null
     */
    public $systemPrompt;
    /**
     * @var float|null
     */
    public $temperature;
    /**
     * @var \Mcp\Types\Meta|null
     */
    public $metadata;
    /**
     * @var \Mcp\Types\ModelPreferences|null
     */
    public $modelPreferences;
    /**
     * @var string|null
     */
    public $includeContext;
    /**
     * @param SamplingMessage[] $messages
     */
    public function __construct(
        array $messages,
        int $maxTokens,
        ?array $stopSequences = null, ?string $systemPrompt = null,
        ?float $temperature = null,
        ?Meta $metadata = null,
        ?ModelPreferences $modelPreferences = null,
        ?string $includeContext = null
    ) {
        $this->messages = $messages;
        $this->maxTokens = $maxTokens;
        $this->stopSequences = $stopSequences;
        // string[]
        $this->systemPrompt = $systemPrompt;
        $this->temperature = $temperature;
        $this->metadata = $metadata;
        $this->modelPreferences = $modelPreferences;
        $this->includeContext = $includeContext;
        parent::__construct('sampling/createMessage');
    }

    public function validate(): void {
        parent::validate();
        if (empty($this->messages)) {
            throw new \InvalidArgumentException('Messages array cannot be empty');
        }
        foreach ($this->messages as $message) {
            if (!$message instanceof SamplingMessage) {
                throw new \InvalidArgumentException('Messages must be instances of SamplingMessage');
            }
            $message->validate();
        }
        if ($this->maxTokens <= 0) {
            throw new \InvalidArgumentException('Max tokens must be greater than 0');
        }
        if ($this->includeContext !== null && !in_array($this->includeContext, ['allServers', 'none', 'thisServer'])) {
            throw new \InvalidArgumentException('Invalid includeContext value');
        }
        if ($this->modelPreferences !== null) {
            $this->modelPreferences->validate();
        }
        // metadata is a Meta object, it's allowed arbitrary fields
        if ($this->metadata !== null) {
            $this->metadata->validate();
        }
    }
}