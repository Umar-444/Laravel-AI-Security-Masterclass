<?php

declare(strict_types=1);

namespace Examples\Ai;

/**
 * PII Redaction Pipeline in PHP 8.4 / Laravel 13
 *
 * Demonstrates:
 * 1. Raw prompt passing unredacted PII [INSECURE]
 * 2. Pre-flight redaction of emails, phones, credit cards, and Saudi National IDs [SECURE]
 */
final class PiiRedactionPipeline
{
    private const array PII_REGEX_MAP = [
        // Credit card numbers (Visa, MasterCard, Amex, Discover)
        '/\b(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|6(?:011|5[0-9]{2})[0-9]{12})\b/'
            => '[REDACTED_CREDIT_CARD]',

        // Email addresses
        '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/'
            => '[REDACTED_EMAIL]',

        // Phone numbers (International and local formats)
        '/(?:\+?\d{1,3}[-.\s]?)?\(?\d{2,4}\)?[-.\s]?\d{3,4}[-.\s]?\d{3,4}/'
            => '[REDACTED_PHONE]',

        // Saudi National ID / Iqama (10 digits starting with 1 or 2 - PDPL compliant)
        '/\b[12]\d{9}\b/'
            => '[REDACTED_SAUDI_ID]',

        // US Social Security Numbers
        '/\b\d{3}-\d{2}-\d{4}\b/'
            => '[REDACTED_SSN]',
    ];

    /**
     * [INSECURE]: Returning raw user string with intact credentials/PII.
     */
    public function vulnerablePreprocess(string $userInput): string
    {
        return $userInput;
    }

    /**
     * [SECURE]: Scans and masks all identifiable personal data before sending upstream.
     */
    public function securePreprocess(string $userInput): string
    {
        $sanitized = $userInput;

        foreach (self::PII_REGEX_MAP as $pattern => $replacement) {
            $sanitized = (string) preg_replace($pattern, $replacement, $sanitized);
        }

        return $sanitized;
    }

    /**
     * Checks if a string contains any PII pattern.
     */
    public function hasPii(string $text): bool
    {
        foreach (array_keys(self::PII_REGEX_MAP) as $pattern) {
            if (preg_match($pattern, $text) === 1) {
                return true;
            }
        }

        return false;
    }
}
