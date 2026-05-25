## Testing TODO (Priority Order)

### 1) Backend Functional First (`tests/backend/functional/`)

- [ ] Cover access matrix: guest vs authenticated vs unauthorized role vs authorized role.
- [ ] Protect critical routes (dashboard and key CRUD endpoints).
- [ ] Verify maintenance mode behavior.

### 2) Common Unit Next (`tests/common/unit/`)

- [ ] Add query scope tests (for example: published scope behavior).
- [ ] Add tests for non-trivial service/helper/validator business logic.

### 3) Backend Unit After (`tests/backend/unit/`)

- [ ] Add isolated tests for small custom behaviors/validators.

### 4) Keep Console/API Selective

- [ ] `tests/console/unit/`: cover critical operational commands.
- [ ] `tests/api/functional/`: add baseline auth, status code, and serialization coverage.

## Safe Quick Wins (This Week)

### Backend Functional (3 tests)

- [ ] `guestCannotAccessDashboard`
- [ ] `authenticatedUserCanAccessDashboard`
- [ ] `unauthorizedRoleCannotAccessArticleCreate`

### Common Unit (2 tests)

- [ ] `publishedScopeReturnsOnlyPublishedArticles`
- [ ] Add one test for the most-used business service/helper.
