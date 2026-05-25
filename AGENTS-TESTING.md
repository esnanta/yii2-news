# Testing Standards

## Testing Philosophy

- Testing must follow Yii2 architecture boundaries and application responsibilities.
- Prioritize deterministic and repeatable tests.
- Every bug fix must include a regression test.
- Prefer realistic application behavior over excessive mocking.
- Functional testing is the primary testing strategy for this project.
- Tests must validate both success and failure scenarios.
- Tests must be isolated and executable in CI environments.
- Avoid network dependency in automated tests.
- Use dedicated test databases and fixtures only.
- Keep business logic testable by placing shared logic inside `common/`.

---

# Testing Priorities

| Testing Type | Priority | Notes |
|---|---|---|
| Functional Testing | Very High | Primary backend validation strategy |
| Unit Testing | High | Business logic validation |
| Integration Testing | High | DB/component interaction validation |
| API Contract Testing | Skeleton Only | Prepare future API usage |
| Acceptance/E2E Testing | Low | Minimal usage initially |

---

# Supported Test Scope

## Active Scope

The following applications must be actively tested:

- `backend/`
- `common/`
- selective `console/`

## Limited Scope

The following applications are optional or minimal:

- `frontend/`
- `api/` (skeleton preparation only)

---

# Test Suite Structure

Project tests must follow Yii2 application boundaries.

```text
tests/
├── common/
│   ├── unit/
│   ├── integration/
│   └── fixtures/
│
├── backend/
│   ├── functional/
│   ├── integration/
│   ├── fixtures/
│   └── _support/
│
├── console/
│   ├── functional/
│   ├── integration/
│   └── fixtures/
│
└── api/
    ├── functional/
    ├── contract/
    └── fixtures/
```

---

# General Testing Rules

## Mandatory Rules

- Every new feature should include tests.
- Every bug fix must include regression tests.
- Tests must not depend on execution order.
- Tests must not share mutable state.
- Tests must not use production databases.
- Tests must not rely on manually created records.
- Use fixtures, factories, or isolated setup methods.
- Avoid sleeping/timing-based assertions.
- Avoid hidden dependencies between tests.

## Naming Convention

Test class names must clearly describe behavior.

Examples:

```php
CreateArticleCest
UpdateUserProfileCest
ArticleQueryTest
GlobalAccessBehaviorTest
```

Test method names should describe expected behavior:

```php
public function guestCannotAccessDashboard()
public function adminCanDeleteArticle()
public function publishedScopeReturnsOnlyPublishedArticles()
```

---

# Unit Testing Standards

## Purpose

Unit tests validate isolated business logic.

## Recommended Targets

Unit tests are recommended for:

- service classes
- helper classes
- query scopes
- validators
- command handlers
- formatters
- DTO mappers
- custom behaviors
- utility classes

Examples:

- `ArticleQuery::published()`
- slug generation
- timeline event builders
- upload filename generators
- RBAC helper logic

## Unit Test Rules

- Keep tests fast and isolated.
- Avoid full Yii application bootstrapping unless necessary.
- Prefer mocks for external services.
- Do not mock the class currently under test.
- Avoid DB usage unless unavoidable.
- Avoid filesystem dependency unless explicitly testing storage behavior.

## Do NOT Unit Test

Avoid unit testing:

- trivial getters/setters
- Yii framework internals
- generated CRUD without custom logic
- pure ActiveRecord persistence already covered by integration tests

---

# Functional Testing Standards

## Purpose

Functional tests validate real Yii2 application behavior.

Functional testing is the primary testing strategy for this project.

## Required Functional Coverage

Functional tests should validate:

- routes
- controllers
- request lifecycle
- RBAC/access control
- redirects
- validation errors
- session/authentication behavior
- maintenance mode
- behaviors and filters
- response rendering
- form submission
- flash messages
- HTTP response codes

## Mandatory Backend Functional Tests

The following backend features must always have functional tests:

- authentication
- logout flow
- password reset flow
- RBAC protected pages
- CRUD actions
- maintenance mode
- upload endpoints
- timeline-related actions
- global access behavior

## Access Control Testing

Every protected backend route must test:

- guest access
- authenticated user access
- insufficient role access
- authorized role access

Example scenarios:

```text
Guest -> redirected to login
User without permission -> forbidden
Admin -> allowed
```

## URL Manager Testing

Routes must be validated through functional tests.

Validate:

- pretty URLs
- route resolution
- allowed HTTP methods
- redirects
- invalid routes
- OPTIONS responses for future APIs

---

# Integration Testing Standards

## Purpose

Integration tests validate collaboration between components.

## Recommended Targets

Integration tests are required for:

- ActiveRecord persistence
- DB transactions
- RBAC persistence
- queue interaction
- event dispatching
- file storage
- Glide integration
- command bus execution
- model behaviors
- lifecycle hooks

## Required Behavior Validation

The following Yii2 behaviors must be integration-tested if customized:

- `TimestampBehavior`
- `SluggableBehavior`
- upload behaviors
- access behaviors
- lifecycle hooks
- timeline events

## DB Rules

- Use dedicated test databases only.
- Transactions should be rolled back between tests where possible.
- Fixtures must remain deterministic.
- Avoid depending on auto-increment IDs unless explicitly controlled.

---

# Console Testing Standards

## Scope

Console tests are selective and focused on operational safety.

## Recommended Console Tests

Test:

- setup commands
- migration commands
- RBAC migrations
- maintenance toggles
- queue workers
- cache clear commands

## Migration Safety

Migration-related tests should validate:

- migration execution
- rollback compatibility where feasible
- schema assumptions
- RBAC initialization

---

# API Testing Skeleton

API testing is currently skeleton-only because API usage is not yet active.

## Future API Principles

Future APIs must follow:

- stateless authentication
- explicit routes
- versioned modules
- JSON-only responses
- consistent serialization
- stable HTTP status handling

## Suggested Future Structure

```text
tests/api/
├── functional/
├── contract/
├── fixtures/
└── _support/
```

## Future API Coverage

When APIs become active, tests must validate:

- authentication
- authorization
- serialization
- status codes
- validation responses
- rate limiting
- version compatibility

## API Contract Rules

Future API resources must never expose:

- internal AR fields
- hidden attributes
- sensitive system metadata

---

# Fixtures and Test Data

## Fixture Rules

- Prefer fixtures over manual DB setup.
- Keep fixtures minimal and readable.
- Avoid oversized fixture datasets.
- Fixtures must be deterministic.

## Test Data Principles

Test data should:

- represent realistic scenarios
- include edge cases
- include invalid cases
- remain isolated per suite

---

# Mocking Strategy

## Allowed Mocking

Mocks are acceptable for:

- external services
- mailers
- queues
- third-party APIs
- expensive integrations

## Avoid Excessive Mocking

Do not excessively mock:

- ActiveRecord queries
- core Yii lifecycle
- RBAC persistence
- request/response behavior

Prefer real application flow for backend functional tests.

---

# CI/CD Testing Requirements

## Mandatory CI Pipeline

Every pull request or deployment pipeline should run:

```text
1. composer install
2. prepare test environment
3. run migrations
4. run unit tests
5. run functional tests
6. run integration tests
7. generate coverage report
```

## CI Requirements

- CI must fail on broken tests.
- CI must use isolated test databases.
- CI environments must never connect to production services.
- Test artifacts should be reproducible.

---

# Coverage Standards

## Coverage Targets

Recommended minimum coverage:

| Area | Target |
|----------------------------|------|
| Overall                    | 70%  |
| Business-critical services | 90%  |
| RBAC logic                 | High |
| Query scopes               | High |
| Controllers                | Scenario-based coverage |

## Coverage Philosophy

Do not chase artificial 100% coverage.

Prioritize:

- critical flows
- security-sensitive logic
- regression-prone areas
- business-critical workflows

---

# Regression Testing Policy

Every production bug fix must include:

- at least one failing test before the fix
- regression coverage preventing recurrence

Regression tests should target the original failure scenario.

---

# Yii2-Specific Testing Guidance

## Fat Models, Lean Controllers

Testing must follow project architecture:

- business logic belongs in models/services
- controllers remain thin
- views remain passive

## ActiveRecord Guidance

Prefer integration tests for ActiveRecord behavior.

Validate:

- scopes
- relations
- behaviors
- lifecycle hooks
- persistence side effects

## Behavior Testing

If custom behaviors exist, validate:

- automatic attribute changes
- event triggers
- interaction with save/update lifecycle

## GlobalAccessBehavior

All access restrictions implemented through:

- `GlobalAccessBehavior`
- RBAC
- controller access rules

must be functionally tested.

## Maintenance Mode

Maintenance mode must include tests for:

- guest access
- admin bypass
- application response behavior

---

# Testing Anti-Patterns

## Avoid

- testing framework internals
- testing generated CRUD without customization
- brittle timing-based assertions
- shared mutable fixtures
- hidden test dependency
- over-mocking
- asserting implementation details instead of behavior

## Never

- use production databases
- rely on execution order
- disable security mechanisms to simplify tests
- bypass RBAC in functional tests

---

# Recommended Commands

Use canonical project commands whenever possible.

Preferred commands:

```bash
composer docker:tests
docker-compose exec -T console vendor/bin/codecept run
```

Avoid legacy taskctl or outdated compose service references unless intentionally updated.

---

# Final Principle

The goal of testing is not merely achieving coverage metrics.

The goal is ensuring:

- backend reliability
- security
- maintainability
- regression prevention
- confidence during refactoring
- safe future API evolution
