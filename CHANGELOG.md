# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Phase 1 AI Security Track: Prompt injection defense, LLM API key & cost control, RAG tenant isolation, agent tool sandboxing, PII redaction pipeline, and model output validation.
- Runnable AI security example implementations in `examples/ai/`.
- Arabic security checklist summary (`docs/checklist.ar.md`) with regional GCC/Saudi PDPL compliance considerations.
- GitHub issue templates (`bug-report.yml`, `new-topic.yml`) and pull request template.
- Contributor Covenant Code of Conduct (`CODE_OF_CONDUCT.md`).

## [1.0.0] - 2026-10-07

### Added
- **Laravel 13 & PHP 8.4 Support**: Full architectural alignment with `bootstrap/app.php` middleware configuration and PHP 8.4 language standards.
- **OWASP API Security Top 10 (2023)**: Complete guide covering BOLA, mass assignment, rate limiting, and SSRF mitigations.
- **Modern Authentication Standards**: NIST SP 800-63B (2024) password complexity, Argon2id parameters, and Passkeys / WebAuthn (FIDO2) passwordless architecture.
- **Hardened HTTP Security Headers**: Nonced CSP, COOP, COEP, CORP, and removal of deprecated `X-XSS-Protection`.
- **Automated Security CI**: GitHub Actions workflow running PHP 8.4 linting, secret detection, and documentation validation.
- **Foundational Security Guides**: 17 comprehensive guides across SQL injection, XSS, CSRF, input sanitization, file uploads, and secure deployment.
