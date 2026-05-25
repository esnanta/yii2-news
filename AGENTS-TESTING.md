# Testing Standards

## Alignment With `AGENTS.md`

- This document follows the architecture in `AGENTS.md`: multi-app Yii2 (`backend/`, `frontend/`, `api/`, `console/`, shared logic in `common/`).
- Primary testing focus remains `backend/` and shared business logic in `common/`.
- `console/` and `api/` are selective/skeleton scope for now.
- Use canonical project commands from `composer.json` and avoid legacy service names.

---

## Testing Philosophy

- Testing is a first-class engineering concern and evolves with the application.
- Every bug fix must include a regression test.
- Prefer deterministic and repeatable tests.
- Tests must be isolated and runnable in local, Docker, and CI environments.
- Avoid external internet and third-party runtime dependencies in automated tests.
- Favor behavior confidence over excessive mocking.
- Keep shared business logic testable in `common/`.

---

## Scope and Priorities

### Primary Scope

- `backend/`
- `common/`

### Secondary Scope

- `console/` (selective)
- `api/` (functional skeleton)
- `frontend/` (currently configured suites exist, but not a top project priority)

### Current Priority

| Testing Type | Priority | Notes |
|---|---|---|
| Functional | Very High | Main strategy for backend behavior and access control |
| Unit | High | Business logic, services, helpers, query logic |
| Integration | Planned / Selective | Add when component collaboration coverage is needed |
| Acceptance/E2E | Low | Exists in backend/frontend, minimal usage |
| API Contract | Skeleton | Prepare gradually as API surface grows |

---

## Current Test Structure (Actual Repository)

```text
tests/
├── common/
│   ├── unit/
│   ├── fixtures/
│   └── _support/
├── backend/
│   ├── functional/
│   ├── unit/
│   ├── acceptance/
│   ├── _pages/
│   └── _support/
├── frontend/
│   ├── functional/
│   ├── unit/
│   ├── acceptance/
│   ├── _pages/
│   └── _support/
├── api/
│   ├── functional/
│   └── _support/
└── console/
    ├── unit/
    └── _support/
```

Notes:
- `integration/` directories are not broadly implemented yet.
- `api/contract/` is not implemented yet.
- `console/functional/` is not implemented yet.

---

## Test Suite Conventions

- Follow Codeception suite boundaries per app.
- Keep test data deterministic (fixtures/factories/isolated setup).
- Do not depend on execution order or shared mutable state.
- Never use production DB/services.
- Prefer asserting externally visible behavior over internal implementation details.

### Naming

Class names should describe behavior:

```php
CreateArticleCest
ArticleQueryTest
GlobalAccessBehaviorTest
```

Method names should describe expectations:

```php
public function guestCannotAccessDashboard()
public function adminCanDeleteArticle()
public function publishedScopeReturnsOnlyPublishedArticles()
```

---

## Functional Testing (Primary)

Functional tests should cover:

- route resolution and HTTP status codes
- controller lifecycle and validation errors
- redirects, sessions, authentication flow
- RBAC and `GlobalAccessBehavior` restrictions
- maintenance mode behavior
- forms, flash messages, and response rendering

### Mandatory Backend Scenarios

- login/logout and password reset flow
- access control (guest / authenticated / unauthorized role / authorized role)
- CRUD permission boundaries
- maintenance mode behavior
- critical upload and timeline-related flows when present

---

## Unit Testing

Recommended targets:

- services, helpers, validators, formatters
- query classes/scopes (e.g. `ArticleQuery::published()`)
- command handlers and small domain utilities
- custom behaviors with isolated logic

Rules:

- keep tests fast and isolated
- avoid full app boot unless required
- avoid DB/filesystem unless that interaction is the test subject
- do not unit test trivial getters/setters or framework internals

---

## Integration Testing (Planned / Selective)

Add integration tests when validating collaboration between components, such as:

- ActiveRecord persistence and lifecycle hooks
- RBAC persistence
- queue dispatch/processing boundaries
- file storage / Glide integration
- command bus + event side effects

If custom behavior changes save/update lifecycle (`TimestampBehavior`, `SluggableBehavior`, upload/access behaviors), add integration coverage.

---

## Console and API Testing

### Console (Selective)

Prioritize tests for operational safety:

- setup/bootstrap commands
- migration and RBAC migration behavior
- maintenance toggle and cache/queue-related commands

### API (Skeleton)

Current API test focus remains minimal functional coverage. As API usage grows, add:

- contract tests
- auth/authorization coverage
- serialization/status consistency
- rate limiting and version compatibility checks

---

## CI and Execution

Preferred commands:

```bash
composer docker:tests
docker-compose exec -T console vendor/bin/codecept run
```

CI expectations:

- fail on test failures
- use isolated test databases
- never connect to production services
- keep results reproducible

---

## Regression Policy

- Every production bug fix must include a regression test.
- Regression tests should target the original failure scenario.
- Prioritize security-sensitive, regression-prone, and business-critical paths.

---

## Final Principle

The goal is confidence during change:

- backend reliability
- access-control safety
- maintainability
- stable refactoring
- safe API evolution
