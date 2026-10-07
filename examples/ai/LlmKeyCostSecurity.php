<?php

declare(strict_types=1);

namespace Examples\Ai;

use RuntimeException;

/**
 * LLM API Key & Cost Security in PHP 8.4 / Laravel 13
 *
 * Demonstrates:
 * 1. Unbounded, rate-unlimited API invocations [INSECURE]
 * 2. Token-budgeted, rate-limited, capped payload generation [SECURE]
 */
final class LlmKeyCostSecurity
{
    private const int MAX_TOKENS_PER_USER_DAILY = 50_000;
    private const int MAX_OUTPUT_TOKENS_PER_CALL = 1_000;

    /**
     * [INSECURE]: Direct env lookup, unbounded max_tokens, zero usage checks.
     */
    public function vulnerableRequestPayload(string $message): array
    {
        // Vulnerable: If user sends a loop, OpenAI charges full max capacity
        return [
            'api_key' => getenv('OPENAI_API_KEY'), // Bad: bypasses config cache
            'payload' => [
                'model' => 'gpt-4o',
                'messages' => [['role' => 'user', 'content' => $message]],
                // No max_tokens limit set!
            ],
        ];
    }

    /**
     * [SECURE]: Verified user token usage budget, bounded output, server-side config.
     */
    public function buildSecureRequestPayload(
        int $userId,
        int $currentDailyTokenUsage,
        string $configuredApiKey,
        string $systemPrompt,
        string $userMessage
    ): array {
        if ($currentDailyTokenUsage >= self::MAX_TOKENS_PER_USER_DAILY) {
            throw new RuntimeException("Daily AI quota reached for user ID {$userId}.");
        }

        if (empty($configuredApiKey)) {
            throw new RuntimeException('API key is not configured.');
        }

        return [
            'headers' => [
                'Authorization' => "Bearer {$configuredApiKey}",
                'Content-Type' => 'application/json',
            ],
            'payload' => [
                'model' => 'gpt-4o-mini',
                'max_tokens' => self::MAX_OUTPUT_TOKENS_PER_CALL,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ],
        ];
    }
}
