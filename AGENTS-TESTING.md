# Testing Standards

## Testing Philosophy

- Testing is a first-class engineering concern and must evolve together with the application.
- Every bug fix must include a regression test that reproduces the original issue.
- Prefer deterministic and repeatable tests.
- Tests must not depend on external internet access or third-party services.
- Tests must remain isolated and executable in any environment (local, Docker, CI).
- Favor confidence and maintainability over excessive mocking.
- Backend stability and access control validation are higher priorities than UI/browser automation.
- Prefer meaningful scenario coverage over artificially maximizing coverage percentages.

---

## Testing Scope

### Primary Scope
The following applications must be actively tested:

- `backend/`
- `common/`

### Secondary Scope
The following applications/components may receive selective or skeleton-level testing:

- `console/`
- `api/`

### Out of Scope (Current Phase)

- Full browser E2E testing
- Frontend/UI interaction testing
- Load/performance testing
- Visual regression testing

---

## Test Suite Structure

Tests must follow the existing Codeception structure.

Recommended structure:

```text
tests/
├── backend/
│   ├── functional/
│   ├── integration/
│   ├── unit/
│   └── fixtures/
│
├── common/
│   ├── unit/
│   ├── integration/
│   └── fixtures/
│
├── console/
│   ├── functional/
│   └── unit/
│
├── api/
│   ├── functional/
│   ├── contract/
│   └── fixtures/
│
└── _support/