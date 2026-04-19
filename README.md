
# Yii2 News

![Version](https://img.shields.io/github/v/tag/esnanta/yii2-news?label=version&color=blue)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-blue)

Yii2 News is an open-source Yii2 application for managing news content, authors, staff, and
assets (images and documents). This project is based on Yii2 Starter Kit and adapted for a news portal workflow.

## Highlights

- Multi-app architecture: `frontend`, `backend`, `api`, `console`, and `storage`
- CMS-like news management: articles, categories, static pages, menus, carousels, and text blocks
- User management with RBAC (`guest`, `user`, `manager`, `administrator`)
- REST API (`api/modules/v1`) with Swagger documentation
- File upload, image processing (Glide), and file storage
- Docker-first development workflow with Codeception test suites

## Application Map

- `frontend/`: public web interface for readers
- `backend/`: admin panel for content and user management
- `api/`: REST API endpoints
- `console/`: setup, migration, and maintenance commands
- `common/`: shared business logic, models, services, and config
- `storage/`: uploaded files and cache serving

Screenshots:

- Frontend
  ![Frontend](https://github.com/esnanta/yii2-news/blob/main/screenshots/home.png)
- Backend
  ![Backend](https://github.com/esnanta/yii2-news/blob/main/screenshots/article_create.png)

## Requirements

- PHP 8.x
- Composer 2.x
- Docker + Docker Compose (recommended)
- Node.js + npm (for asset build)

## Installation (Recommended: Docker)

This section follows the Starter Kit installation flow, adapted to this repository workflow.

1. Clone repository

```bash
git clone https://github.com/esnanta/yii2-news.git
cd yii2-news
```

2. Build and start the application stack

```bash
composer docker:build
```

The command above automatically:

- creates `.env` from `.env.dist`
- starts Docker containers
- installs PHP dependencies
- runs app setup (`php console/yii app/setup --interactive=0`)
- installs frontend dependencies (`npm install`) and builds bundles (`npm run build`)

3. Add local hosts (if not already configured)

```bash
sudo sh -c 'cat >> /etc/hosts <<EOF
127.0.0.1 yii2-starter-kit.localhost
127.0.0.1 backend.yii2-starter-kit.localhost
127.0.0.1 api.yii2-starter-kit.localhost
127.0.0.1 storage.yii2-starter-kit.localhost
EOF'
```

4. Open the applications

- Frontend: `http://yii2-starter-kit.localhost`
- Backend: `http://backend.yii2-starter-kit.localhost`
- API base: `http://api.yii2-starter-kit.localhost`
- Storage: `http://storage.yii2-starter-kit.localhost`
- Mailcatcher: `http://localhost:1080`

## Default Accounts

Seed data from migrations includes:

- `administrator`: `webmaster` / `webmaster`
- `manager`: `manager` / `manager`
- `user`: `user` / `user`

## Manual Installation (Non-Docker)

If you are not using Docker, you can set up manually:

```bash
cp .env.dist .env
composer install --prefer-dist -o
php console/yii app/setup --interactive=0
npm install
npm run build
```

Then point your web server to each app entry point:

- `frontend/web/index.php`
- `backend/web/index.php`
- `api/web/index.php`
- `storage/web/index.php`

## API and Swagger

- Swagger UI: `http://api.yii2-starter-kit.localhost/site/docs`
- OpenAPI JSON: `http://api.yii2-starter-kit.localhost/site/json-schema`
- Currently active API route: `v1/article` (`index`, `view`, `options`)

## Development Workflow

Use the repository composer scripts:

```bash
composer docker:start
composer docker:build
composer docker:tests
composer docker:cleanup
```

Run the test suite in a separate terminal after `composer docker:tests`:

```bash
docker-compose exec -T console vendor/bin/codecept run
```

## Database Utilities

Destructive database reset:

```bash
php console/yii migrate/fresh --interactive=0
php console/yii rbac-migrate/up --interactive=0
```

## Notes

- Environment values are loaded from `.env` via `common/env.php` (`env()` helper)
- API routing is defined explicitly in `api/config/_urlManager.php`
- If Linux bind-mount permissions drift, fix permissions for `frontend/runtime`, `frontend/web/assets`, `backend/runtime`, and `backend/web/assets`

## Contribution

Pull requests, issues, and suggestions are welcome.

## License

This project is released under the MIT License. See [LICENSE](LICENSE.md).
