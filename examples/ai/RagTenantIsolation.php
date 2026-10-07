<?php

declare(strict_types=1);

namespace Examples\Ai;

use InvalidArgumentException;

/**
 * RAG Tenant Isolation Patterns in PHP 8.4 / Laravel 13
 *
 * Demonstrates:
 * 1. Unfiltered vector query with naive prompt instructions [INSECURE]
 * 2. Hard database / vector query tenant scoping [SECURE]
 */
final class RagTenantIsolation
{
    /**
     * [INSECURE]: Global search across all tenants, relying on prompt for isolation.
     */
    public function vulnerableRagQuery(string $searchQuery, int $tenantId): array
    {
        // Vulnerable: Querying all document chunks regardless of tenant!
        $sql = "SELECT id, content FROM document_chunks ORDER BY embedding <=> :embedding LIMIT 5";

        $systemPrompt = "You are a bot for tenant {$tenantId}. Only use data belonging to this tenant.";

        return [
            'sql' => $sql,
            'system_prompt' => $systemPrompt,
        ];
    }

    /**
     * [SECURE]: Hard tenant parameter binding at the database layer.
     */
    public function buildIsolatedTenantQuery(int $authenticatedTenantId, int $userId): array
    {
        if ($authenticatedTenantId <= 0) {
            throw new InvalidArgumentException('Invalid tenant identifier.');
        }

        // Hard isolation in PostgreSQL pgvector or MySQL 9.0 vector store
        $sql = <<<SQL
SELECT id, content, document_id
FROM document_chunks
WHERE tenant_id = :tenant_id
  AND (visibility = 'public' OR owner_id = :user_id)
ORDER BY embedding <=> :embedding
LIMIT 4;
SQL;

        return [
            'query' => $sql,
            'bindings' => [
                'tenant_id' => $authenticatedTenantId,
                'user_id' => $userId,
            ],
        ];
    }
}
