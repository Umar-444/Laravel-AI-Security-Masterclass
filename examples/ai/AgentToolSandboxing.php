<?php

declare(strict_types=1);

namespace Examples\Ai;

use InvalidArgumentException;
use RuntimeException;

/**
 * AI Agent Tool Sandboxing in PHP 8.4 / Laravel 13
 *
 * Demonstrates:
 * 1. Arbitrary function dispatch without allowlists [INSECURE]
 * 2. Strict tool allowlist, parameter validation, and human-in-the-loop gates [SECURE]
 */
final class AgentToolSandboxing
{
    /** @var array<string, callable> */
    private array $allowedTools = [];

    private const array DESTRUCTIVE_TOOLS = [
        'issue_refund',
        'delete_user_account',
        'execute_payment',
    ];

    public function registerTool(string $name, callable $handler): void
    {
        $this->allowedTools[$name] = $handler;
    }

    /**
     * [INSECURE]: Executing dynamic method names or raw SQL based on AI output.
     */
    public function vulnerableDispatch(string $toolName, array $args): mixed
    {
        // Vulnerable: If the LLM generates 'system', 'unlink', or private methods, it runs!
        if (is_callable($toolName)) {
            return $toolName(...$args);
        }

        return null;
    }

    /**
     * [SECURE]: Verified against strict allowlist with authorization & confirmation requirements.
     */
    public function secureDispatch(string $toolName, array $validatedArgs, bool $humanApproved = false): array
    {
        // 1. Strict allowlist check
        if (!array_key_exists($toolName, $this->allowedTools)) {
            throw new InvalidArgumentException("Tool [{$toolName}] is not in the approved agent allowlist.");
        }

        // 2. Human-in-the-loop requirement for destructive actions
        if (in_array($toolName, self::DESTRUCTIVE_TOOLS, true) && !$humanApproved) {
            return [
                'status' => 'pending_human_approval',
                'action_token' => bin2hex(random_bytes(16)),
                'message' => "Tool [{$toolName}] requires human supervisor authorization before execution.",
            ];
        }

        $tool = $this->allowedTools[$toolName];
        $result = $tool($validatedArgs);

        return [
            'status' => 'executed',
            'result' => $result,
        ];
    }
}
