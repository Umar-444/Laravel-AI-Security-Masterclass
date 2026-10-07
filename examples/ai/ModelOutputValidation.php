<?php

declare(strict_types=1);

namespace Examples\Ai;

use JsonException;
use RuntimeException;

/**
 * Model Output Validation in PHP 8.4 / Laravel 13
 *
 * Demonstrates:
 * 1. Blindly trusting LLM output in database / HTML [INSECURE]
 * 2. Strict JSON schema decode, validation, and sanitization [SECURE]
 */
final class ModelOutputValidation
{
    /**
     * [INSECURE]: Direct string interpolation of LLM output into SQL and HTML.
     */
    public function vulnerableConsumer(string $llmGeneratedOutput): array
    {
        // Vulnerability: Second-order SQL injection and XSS
        return [
            'dangerous_sql' => "UPDATE notes SET summary = '{$llmGeneratedOutput}' WHERE id = 1",
            'dangerous_blade' => "<div>{!! \$aiOutput !!}</div>",
        ];
    }

    /**
     * [SECURE]: Decodes and validates structured schema, type-casts, and strips residual tags.
     *
     * @return array{category: string, sentiment: string, confidence: float, summary: string}
     */
    public function secureConsumer(string $rawJsonFromLlm): array
    {
        try {
            $data = json_decode($rawJsonFromLlm, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Model did not return valid JSON: ' . $e->getMessage());
        }

        if (!is_array($data)) {
            throw new RuntimeException('Expected array structure from model output.');
        }

        // Schema validation
        $category = (string) ($data['category'] ?? '');
        $sentiment = (string) ($data['sentiment'] ?? '');
        $confidence = (float) ($data['confidence'] ?? 0.0);
        $summary = (string) ($data['summary'] ?? '');

        $allowedCategories = ['billing', 'technical', 'sales', 'general'];
        if (!in_array($category, $allowedCategories, true)) {
            $category = 'general';
        }

        $allowedSentiments = ['positive', 'neutral', 'negative'];
        if (!in_array($sentiment, $allowedSentiments, true)) {
            $sentiment = 'neutral';
        }

        $confidence = max(0.0, min(1.0, $confidence));

        // Sanitize string content against any embedded HTML/XSS payloads
        $cleanSummary = strip_tags($summary);

        return [
            'category' => $category,
            'sentiment' => $sentiment,
            'confidence' => $confidence,
            'summary' => $cleanSummary,
        ];
    }
}
