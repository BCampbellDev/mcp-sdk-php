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
 * Filename: Types/ServerCapabilities.php
 */

declare(strict_types=1);

namespace Mcp\Types;

/**
 * Server capabilities
 * According to the schema:
 * ServerCapabilities {
 *   experimental?: { ... },
 *   logging?: object,
 *   completions?: object,
 *   prompts?: { listChanged?: boolean },
 *   resources?: { subscribe?: boolean, listChanged?: boolean },
 *   tools?: { listChanged?: boolean },
 *   [key: string]: unknown
 * }
 */
class ServerCapabilities extends Capabilities {
    /**
     * @var \Mcp\Types\ServerLoggingCapability|null
     */
    public $logging;
    /**
     * @var \Mcp\Types\ServerCompletionsCapability|null
     */
    public $completions;
    /**
     * @var \Mcp\Types\ServerPromptsCapability|null
     */
    public $prompts;
    /**
     * @var \Mcp\Types\ServerResourcesCapability|null
     */
    public $resources;
    /**
     * @var \Mcp\Types\ServerToolsCapability|null
     */
    public $tools;
    public function __construct(
        ?ServerLoggingCapability $logging = null,
        ?ServerCompletionsCapability $completions = null,
        ?ServerPromptsCapability $prompts = null,
        ?ServerResourcesCapability $resources = null,
        ?ServerToolsCapability $tools = null,
        ?ExperimentalCapabilities $experimental = null
    ) {
        $this->logging = $logging;
        $this->completions = $completions;
        $this->prompts = $prompts;
        $this->resources = $resources;
        $this->tools = $tools;
        parent::__construct($experimental);
    }

    /**
     * @return $this
     */
    public static function fromArray(array $data): \Mcp\Types\Capabilities {
        // Handle experimental from parent class
        $experimentalData = $data['experimental'] ?? null;
        unset($data['experimental']);
        $experimental = null;
        if ($experimentalData !== null && is_array($experimentalData)) {
            $experimental = ExperimentalCapabilities::fromArray($experimentalData);
        }

        $loggingData = $data['logging'] ?? null;
        unset($data['logging']);
        $logging = null;
        if ($loggingData !== null && is_array($loggingData)) {
            $logging = ServerLoggingCapability::fromArray($loggingData);
        }

        $completionsData = $data['completions'] ?? null;
        unset($data['completions']);
        $completions = null;
        if ($completionsData !== null && is_array($completionsData)) {
            $completions = ServerCompletionsCapability::fromArray($completionsData);
        }

        $promptsData = $data['prompts'] ?? null;
        unset($data['prompts']);
        $prompts = null;
        if ($promptsData !== null && is_array($promptsData)) {
            $prompts = ServerPromptsCapability::fromArray($promptsData);
        }

        $resourcesData = $data['resources'] ?? null;
        unset($data['resources']);
        $resources = null;
        if ($resourcesData !== null && is_array($resourcesData)) {
            $resources = ServerResourcesCapability::fromArray($resourcesData);
        }

        $toolsData = $data['tools'] ?? null;
        unset($data['tools']);
        $tools = null;
        if ($toolsData !== null && is_array($toolsData)) {
            $tools = ServerToolsCapability::fromArray($toolsData);
        }

        // Construct ServerCapabilities object
        $obj = new self(
            $logging,
            $completions,
            $prompts,
            $resources,
            $tools,
            $experimental
        );

        // Extra fields
        foreach ($data as $k => $v) {
            $obj->$k = $v;
        }

        $obj->validate();
        return $obj;
    }

    public function validate(): void {
        parent::validate();
        if ($this->prompts !== null) {
            $this->prompts->validate();
        }
        if ($this->resources !== null) {
            $this->resources->validate();
        }
        if ($this->tools !== null) {
            $this->tools->validate();
        }
        if ($this->logging !== null) {
            $this->logging->validate();
        }
        if ($this->completions !== null) {
            $this->completions->validate();
        }
    }

    /**
     * @return mixed
     */
    public function jsonSerialize() {
        $data = parent::jsonSerialize();
        if ($this->logging !== null) {
            $data['logging'] = $this->logging;
        }
        if ($this->completions !== null) {
            $data['completions'] = $this->completions;
        }
        if ($this->prompts !== null) {
            $data['prompts'] = $this->prompts;
        }
        if ($this->resources !== null) {
            $data['resources'] = $this->resources;
        }
        if ($this->tools !== null) {
            $data['tools'] = $this->tools;
        }
        return $data;
    }
}