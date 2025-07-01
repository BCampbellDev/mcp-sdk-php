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
 * Filename: Shared/RequestResponder.php
 */

declare(strict_types=1);

namespace Mcp\Shared;

use Mcp\Types\RequestId;
use Mcp\Shared\ErrorData;
use Mcp\Types\McpModel;
use Mcp\Types\Meta;
use RuntimeException;

/**
 * Handles responding to individual requests.
 *
 * Similar to the Python RequestResponder, which stores request_id, request_meta, request, and session.
 * Here, we assume `$request` is a typed request (McpModel) and `$params` are its parameters.
 */
class RequestResponder {
    /**
     * @var RequestId
     * @readonly
     */
    private $requestId;
    /**
     * @var array
     * @readonly
     */
    private $params;
    /**
     * @var McpModel
     * @readonly
     */
    private $request;
    /**
     * @var BaseSession
     * @readonly
     */
    private $session;
    /**
     * @var bool
     */
    private $responded = false;
    /**
     * @var \Mcp\Types\Meta|null
     */
    private $requestMeta;

    /**
     * @param RequestId $requestId The ID of the request being handled.
     * @param array $params The request parameters.
     * @param McpModel $request The typed request object.
     * @param BaseSession $session The session handling communication.
     */
    public function __construct(
        RequestId $requestId,
        array $params,
        McpModel $request,
        BaseSession $session
    ) {
        $this->requestId = $requestId;
        $this->params = $params;
        $this->request = $request;
        $this->session = $session;
        $this->extractMeta();
    }

    /**
     * Sends a response to the request. The response can be a typed result or an ErrorData object for errors.
     *
     * @param mixed $response
     */
    public function respond($response): void {
        if ($this->responded) {
            throw new RuntimeException('Request already responded to');
        }
        $this->responded = true;

        $this->session->sendResponse($this->requestId, $response);
    }

    /**
     * @param mixed $response
     */
    public function sendResponse($response): void {
        $this->respond($response);
    }

    public function getRequest(): McpModel {
        return $this->request;
    }

    /**
     * Returns the Meta object associated with the request, if any.
     */
    public function getMeta(): ?Meta {
        return $this->requestMeta;
    }

    /**
     * Extracts '_meta' from params if present and creates a Meta object.
     */
    private function extractMeta(): void {
        if (isset($this->params['_meta']) && is_array($this->params['_meta'])) {
            $this->requestMeta = new Meta();
            foreach ($this->params['_meta'] as $key => $value) {
                $this->requestMeta->$key = $value;
            }
        }
    }
}