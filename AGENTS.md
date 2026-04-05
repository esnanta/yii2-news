# AGENTS.md

## Core architecture (read first)
- This is a Yii2 advanced-style multi-app repo: `frontend/`, `backend/`, `api/`, `console/`, shared logic in `common/`, file serving in `storage/`.
- App boot order is consistent: `common/config/base.php` + common web/console config + app `config/base.php` + app `config/web.php` (see `frontend/web/index.php`, `backend/web/index.php`, `api/web/index.php`, `console/yii`).
- Aliases are centralized in `common/config/bootstrap.php` (`@frontend`, `@backend`, `@api`, `@storage`, plus `@frontendUrl`/`@backendUrl`/`@apiUrl`/`@storageUrl`).
- Environment must come from `.env` via `common/env.php` and `env()` in `common/helpers.php` (avoid raw `getenv()` in app code).

## Runtime boundaries and request flow
- Nginx routes hostnames to separate PHP-FPM services (`docker/nginx/vhost.conf`): `api.*` -> `api`, `backend.*` -> `backend`, root host -> `frontend`, `storage.*` -> `storage`.
- API v1 behavior is module-driven in `api/modules/v1/Module.php`: JSON/XML content negotiation, rate limiting, and stateless auth (`enableSession=false`).
- API routes are explicit in `api/config/_urlManager.php` (currently only `v1/article` for `index`, `view`, `options`).
- Swagger docs come from `api/controllers/SiteController.php` (`site/docs` and `site/json-schema`) scanning `api/modules/v1/controllers` + `api/modules/v1/models`.

## Shared infrastructure and side effects
- `common/config/base.php` defines core services: DB, RBAC (`DbManager`), `commandBus`, file queue (`yii\\queue\\file\\Queue`), Glide, file storage, key storage, and cross-app URL managers.
- User lifecycle emits timeline events from model hooks in `common/models/User.php` (`notifySignup` / `notifyDeletion` via `AddToTimelineCommand`).
- Backend authorization is enforced globally in `backend/config/web.php` via `as globalAccess` and `common/behaviors/GlobalAccessBehavior.php`.
- Maintenance mode is bootstrapped in frontend/api (`common/components/maintenance/Maintenance.php`) and toggled by `APP_MAINTENANCE` or key storage flags.

## Developer workflows
- Initial setup path: `php console/yii app/setup --interactive=0` (permissions, keys, DB + RBAC migrations; see `console/controllers/AppController.php`).
- Prefer canonical composer scripts in `composer.json`: `composer docker:start`, `composer docker:build`, `composer docker:tests`.
- Frontend/backend bundles are produced by webpack to `frontend/web/bundle` and `backend/web/bundle` (`webpack.config.js`, `npm run build`).
- Tests are Codeception per app (`tests/{common,console,backend,frontend,api}` + root `codeception.yml`), with `tests/bin/yii` and `TEST_DB_*` env vars.
- `taskctl.yaml` references old compose service names (`app`, `webpacker`) while `docker-compose.yml` uses `console`, `node`; use composer scripts unless intentionally updating taskctl.

## Project conventions (important)
- Put shared business logic in `common/`; keep app-specific code in `frontend/`, `backend/`, or `api/`.
- Reuse query scopes via custom query classes (example: `common/models/query/ArticleQuery.php::published()`) and use eager loading where expected.
- API resources should extend common AR models and trim/shape fields (example: `api/modules/v1/resources/Article.php`) instead of duplicating model logic.
- Add/adjust routes in app `_urlManager.php` files first; avoid hiding routing behavior inside controllers.
- Check `behaviors()` before adding manual lifecycle logic (timestamp, sluggable, upload, login timestamp, access behaviors are heavily used).

## AI and MCP references
- Root AI guidance present: `README.md`.
- Console-local AI framework guides exist in `console/.rules`, `console/.cursor/rules/yii2-boost.mdc`, and `console/.ai/guidelines/...` (mostly generic Yii2 guidance).
- MCP integration exists in `console/.mcp.json` as server `yii2-boost` running `php console/yii boost/mcp`; treat as optional tooling and verify local PHP path compatibility.
