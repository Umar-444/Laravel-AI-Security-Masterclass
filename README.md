# Laravel AI Security Masterclass

[![Security Workflow](https://github.com/Umar-444/Laravel-AI-Security-Masterclass/actions/workflows/security.yml/badge.svg)](https://github.com/Umar-444/Laravel-AI-Security-Masterclass/actions/workflows/security.yml)
[![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue)](https://www.php.net/)
[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-red)](https://laravel.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![Last Updated](https://img.shields.io/badge/Updated-October%202026-green)]()

The security guide and runnable reference for Laravel developers shipping modern web applications and AI features. Built for developers, architects, and teams who need production-ready vulnerability prevention for PHP 8.4 and Laravel 13, covering everything from core OWASP defenses to prompt injection, RAG tenant isolation, and autonomous agent sandboxing.

---

## Author & Contact

**Umar Farooq** — Senior PHP Laravel Developer | Web Security & AI Architecture

- **Email**: [contact@itsumarfarooq.com](mailto:contact@itsumarfarooq.com)
- **Website**: [itsumarfarooq.com](https://itsumarfarooq.com)
- **Company**: [Worldwebtree.com](https://worldwebtree.com)
- **LinkedIn**: [linkedin.com/in/umar444](https://www.linkedin.com/in/umar444)
- **GitHub**: [github.com/umar-444](https://github.com/umar-444)
- **X (Twitter)**: [@umartechtalks](https://x.com/umartechtalks)
- **Specialization**: PHP Laravel Development, Web Application Security, AI in Laravel, Secure Architecture
- **Experience**: 5+ years in PHP development, Laravel architecture, and secure software engineering
- **Expertise**: OWASP Top 10 (2025), OWASP LLM Top 10 (2025), Passkeys/WebAuthn, API security, RAG tenant isolation, AI agent sandboxing

---

## Requirements

| Requirement | Minimum | Recommended |
|---|---|---|
| PHP | 8.2 | **8.4** |
| Laravel | 11.x | **13.x** |
| Composer | 2.5 | **2.8+** |

> **Warning: End-of-Life Notice:** PHP 8.1 reached EOL on November 25, 2024. Laravel 10 reached EOL on February 4, 2025. Do **not** use these in production.

---

## Masterclass Curriculum

Structured learning path organized into 6 core tracks:

### Track 01: Foundations & Architecture
- **[Secure Coding Basics](docs/01-foundations/secure-coding-basics.md)** - Security development lifecycle, threat modeling, and defense principles
- **[PHP Security Fundamentals](docs/01-foundations/php-security.md)** - PHP 8.4 security standards, safe typing, enums, and configuration
- **[Laravel Security Architecture](docs/01-foundations/laravel-security.md)** - Laravel 13 framework security features, service container, and middleware
- *Examples*: [Secure vs Insecure Patterns](examples/SecureVsInsecureExamples.php)

### Track 02: Authentication & Session Security
- **[Password Handling & Passkeys](docs/02-authentication/password-handling.md)** - NIST SP 800-63B standards, Argon2id, MFA, and FIDO2 Passkeys / WebAuthn
- **[Session Security Management](docs/02-authentication/session-security.md)** - Session fixation prevention, strict cookie flags, and session regeneration
- *Examples*: [Secure Login System](examples/PHP/SecureLogin.php) | [Advanced Authentication](examples/AuthenticationExamples.php) | [Session Security Examples](examples/SessionSecurityExamples.php)

### Track 03: Input Handling & Attack Prevention
- **[Input Handling & Validation](docs/03-input-validation/input-handling.md)** - Form requests, type coercion, and context-aware sanitization
- **[SQL Injection Prevention](docs/03-input-validation/sql-injection.md)** - Prepared statements, parameterized queries, and Eloquent ORM security
- **[Cross-Site Scripting (XSS) Defense](docs/03-input-validation/xss-protection.md)** - Output escaping, Blade sanitization, and strict CSP with nonces
- **[CSRF Protection Guide](docs/03-input-validation/csrf-protection.md)** - SameSite=Strict cookies, token validation, and API exempt routing
- **[File Upload Security](docs/03-input-validation/file-uploads.md)** - MIME sniffing prevention, malware scanning, and isolated storage
- *Examples*: [Input Validation](examples/InputValidationExamples.php) | [SQL Injection](examples/SQLInjectionExamples.php) | [XSS Protection](examples/XSSProtectionExamples.php) | [CSRF Protection](examples/CSRFProtectionExamples.php) | [Safe File Upload](examples/PHP/SafeUpload.php) | [Upload Security](examples/FileUploadSecurityExamples.php)

### Track 04: API Security & OWASP Top 10
- **[API Security Basics](docs/04-api-security/api-security-basics.md)** - OWASP API Security Top 10 (2023), Sanctum 4.x, BOLA prevention, and rate limiting
- **[Common Vulnerabilities](docs/04-api-security/common-vulnerabilities.md)** - Comprehensive breakdown of OWASP Top 10 (2025 edition)
- *Examples*: [API Security Implementation](examples/APISecurityExamples.php)

### Track 05: AI & LLM Application Security (New)
- **[Prompt Injection Defense](docs/05-ai-security/prompt-injection-defense.md)** - Direct/indirect injection, system prompt hardening, and XML delimitation
- **[LLM API Key & Cost Security](docs/05-ai-security/llm-key-cost-security.md)** - Denial-of-wallet mitigation, per-user token quotas, and sliding-window rate limiting
- **[RAG Tenant Isolation](docs/05-ai-security/rag-tenant-isolation.md)** - Vector search scoping, tenant ACL filtering, and preventing cross-tenant document leakage
- **[AI Agent Tool Sandboxing](docs/05-ai-security/agent-tool-sandboxing.md)** - Tool allowlists, argument validation, Laravel Gates, and human-in-the-loop approval
- **[PII Redaction Pipeline](docs/05-ai-security/pii-redaction-pipeline.md)** - Pre-flight sanitization of emails, phones, credit cards, and Saudi National IDs
- **[Model Output Validation](docs/05-ai-security/model-output-validation.md)** - Second-order injection defense, structured JSON schema outputs, and safe Blade rendering
- *Runnable Examples*:
  - [Prompt Injection Defense](examples/ai/PromptInjectionDefense.php)
  - [LLM Key & Cost Control](examples/ai/LlmKeyCostSecurity.php)
  - [RAG Tenant Isolation](examples/ai/RagTenantIsolation.php)
  - [Agent Tool Sandboxing](examples/ai/AgentToolSandboxing.php)
  - [PII Redaction Pipeline](examples/ai/PiiRedactionPipeline.php)
  - [Model Output Validation](examples/ai/ModelOutputValidation.php)

### Track 06: Hardening, Deployment & CI
- **[Secure Configuration Guide](docs/06-deployment/secure-configuration.md)** - Production `.env` encryption, hiding debug disclosures, and `php.ini` hardening
- **[Secure HTTP Headers](docs/06-deployment/secure-headers.md)** - CSP nonces, COEP, COOP, CORP, HSTS, and removal of deprecated `X-XSS-Protection`
- **[Secure Deployment & Infrastructure](docs/06-deployment/secure-deployment.md)** - TLS 1.3-first, ECDSA certificates, UFW/nftables firewalls, and Fail2Ban
- **[Error Handling & Logging](docs/06-deployment/error-handling-logging.md)** - Secure error pages, structured logging, and incident response
- *Examples*: [Secure Configuration](examples/SecureConfigurationExamples.php) | [Secure Headers Middleware](examples/Laravel/Middleware/SecureHeaders.php) | [Secure Deployment Automation](examples/SecureDeploymentExamples.php)

### Security Assessment Checklists
- **[Master 2026 Security Checklist (English)](docs/checklist.md)** - 200+ point security verification guide including AI and Saudi PDPL compliance
- **[قائمة تدقيق الأمان الشاملة (العربية)](docs/checklist.ar.md)** - دليل الأمان المرجعي الشامل باللغة العربية مع متطلبات نظام حماية البيانات الشخصية السعودي (PDPL / سدايا)

---

## Quick Start Guide

Get started with Laravel security best practices in 5 simple steps:

1. **Security Assessment** - Review [Security Checklist](docs/checklist.md) for vulnerability auditing and compliance checks.
2. **Master Foundations** - Study [PHP Security Fundamentals](docs/01-foundations/php-security.md) and [Laravel Security Architecture](docs/01-foundations/laravel-security.md).
3. **Prevent Core Web Attacks** - Implement SQL injection prevention, XSS output sanitization, and CSRF token defenses.
4. **Secure AI Features** - Apply [Prompt Injection Defense](docs/05-ai-security/prompt-injection-defense.md) and [PII Redaction](docs/05-ai-security/pii-redaction-pipeline.md) before shipping LLM endpoints.
5. **Production Hardening** - Deploy [Secure HTTP Headers](docs/06-deployment/secure-headers.md) and configure TLS 1.3 using [Secure Deployment Guide](docs/06-deployment/secure-deployment.md).

---

## Search & Discovery Keywords

**Primary Topics**: Laravel 13 security guide, PHP 8.4 security best practices, web application security 2026, secure coding PHP, Laravel vulnerability prevention, AI security in Laravel, LLM prompt injection defense, RAG tenant isolation, AI agent security.

**Security Standards**: OWASP Top 10 (2025 edition), OWASP API Security Top 10 (2023 edition), OWASP Top 10 for LLM Applications (2025 edition), NIST SP 800-63B (2024 revision), Saudi Personal Data Protection Law (PDPL / SDAIA), FIDO2 / WebAuthn Passkeys.

**Technical Implementations**: SQL injection prevention, prepared statements, XSS defense, Content-Security-Policy nonces, CSRF protection, Argon2id hashing, session security, Sanctum 4.x authentication, rate limiting, PII redaction pipeline, JSON schema structured outputs, second-order injection mitigation.

---

## Why This Repository Exists

### Built for the PHP Laravel Community
This guide was created to provide production-ready solutions for real-world security challenges in modern Laravel and AI-driven applications. Rather than abstract theory, every guide is paired with runnable code examples, threat models, and concrete mitigation steps.

### Complete Security Coverage
- **23 In-Depth Guides** covering web fundamentals, API protection, AI application security, and production hardening
- **21 Practical Code Examples** with clear `[INSECURE]` vs `[SECURE]` comparisons
- **80+ Security Topics** from basic password hashing to autonomous AI agent tool sandboxing
- **Full Compliance Alignment** with OWASP Top 10 (2025), OWASP LLM (2025), and Saudi PDPL

---

## Contributing

We welcome community contributions! Please review our [Contributing Guide](CONTRIBUTING.md) and [Code of Conduct](CODE_OF_CONDUCT.md) before submitting pull requests.

Security vulnerabilities in this repository should be reported responsibly via [Private Security Advisories](https://github.com/Umar-444/Laravel-AI-Security-Masterclass/security/advisories/new) or directly to [contact@itsumarfarooq.com](mailto:contact@itsumarfarooq.com).

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Important Security Disclaimer

This repository provides comprehensive PHP Laravel security best practices and code patterns. Security is an ongoing process that requires continuous monitoring, testing, and domain expertise. Always perform independent penetration testing, code reviews, and dependency audits (`composer audit`) before deploying code to production.

---

## Get Help & Support

- **[Master Security Checklist](docs/checklist.md)** — Comprehensive 2026 security assessment guide
- **[قائمة تدقيق الأمان (بالعربية)](docs/checklist.ar.md)** — الدليل المرجعي للأمان والامتثال لنظام حماية البيانات الشخصية السعودي
- **[Report Issues](https://github.com/Umar-444/Laravel-AI-Security-Masterclass/issues)** — Bug reports and documentation improvements
- **[Suggest a Topic](https://github.com/Umar-444/Laravel-AI-Security-Masterclass/issues/new?template=new-topic.yml)** — Propose new security guides or threat patterns
- **[Security Policy](SECURITY.md)** — Vulnerability reporting guidelines
- **Direct Email**: [contact@itsumarfarooq.com](mailto:contact@itsumarfarooq.com)
- **Personal Website**: [itsumarfarooq.com](https://itsumarfarooq.com)
- **Company**: [Worldwebtree.com](https://worldwebtree.com)
- **LinkedIn**: [linkedin.com/in/umar444](https://www.linkedin.com/in/umar444)
- **X (Twitter)**: [@umartechtalks](https://x.com/umartechtalks)
- **GitHub Profile**: [github.com/umar-444](https://github.com/umar-444)

---

Built by [Umar Farooq](https://itsumarfarooq.com) for the PHP Laravel community.

*Last Reviewed: October 2026 — Laravel 13 / PHP 8.4*
