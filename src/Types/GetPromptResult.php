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
 * Filename: Types/GetPromptResult.php
 */

declare(strict_types=1);

namespace Mcp\Types;

class GetPromptResult extends Result {
    /**
     * @var PromptMessage[]
     * @readonly
     */
    public $messages;
    /**
     * @var string|null
     */
    public $description;
    /**
     * @param PromptMessage[] $messages
     */
    public function __construct(
        array $messages,
        ?string $description = null,
        ?Meta $_meta = null
    ) {
        $this->messages = $messages;
        $this->description = $description;
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

        $messagesData = $data['messages'] ?? [];
        $description = $data['description'] ?? null;
        unset($data['messages'], $data['description']);

        $messages = [];
        foreach ($messagesData as $m) {
            if (!is_array($m)) {
                throw new \InvalidArgumentException('Invalid message data in GetPromptResult');
            }
            $messages[] = PromptMessage::fromArray($m);
        }

        $obj = new self($messages, $description, $meta);

        // Extra fields
        foreach ($data as $k => $v) {
            $obj->$k = $v;
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        parent::validate();
        foreach ($this->messages as $message) {
            if (!$message instanceof PromptMessage) {
                throw new \InvalidArgumentException('Messages must be instances of PromptMessage');
            }
            $message->validate();
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = parent::jsonSerialize();
        $data['messages'] = $this->messages;
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }
        return $data;
    }
}