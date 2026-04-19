
# Yii2 News

![Version](https://img.shields.io/github/v/tag/esnanta/yii2-news?label=version&color=blue)
![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)
![PHP](https://img.shields.io/badge/PHP-8.x-blue)

Yii2 News is an open-source Yii2 application for managing news content, authors, staff, and assets (images and documents).
This project is based on Yii2 Starter Kit and adapted for a news portal workflow.

- Repository: https://github.com/esnanta/yii2-news
- Issues: https://github.com/esnanta/yii2-news/issues

## Features

### Admin backend
- Dashboard theme: [AdminLTE 3](https://adminlte.io/themes/v3/)
- Content management: articles, categories, static pages, menus, carousels, and text blocks
- Settings editor (KeyStorage based)
- [File manager](https://github.com/MihailDev/yii2-elfinder)
- Users and RBAC management
- Events timeline, logs viewer, and system monitoring

## Application map

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

### Docker path (recommended)
- Docker
- Docker Compose
- Composer 2.x

### Manual path (without Docker)
- PHP 8.x
- Composer 2.x
- Node.js + npm
- MySQL/MariaDB
- Web server (Nginx/Apache)

## Installation

Choose one installation path:

- [Docker installation](#docker-installation-recommended)
- [Manual installation](#manual-installation-non-docker)

### Docker installation (recommended)

1. Copy environment file:

```bash
cp .env.dist .env
```

2. Build and set up app/services:

```bash
composer docker:build
```

3. Start containers (if not already running):

```bash
composer docker:start
```

4. Open applications:

- Frontend: `http://yii2-starter-kit.localhost`
- Backend: `http://backend.yii2-starter-kit.localhost`
- API base: `http://api.yii2-starter-kit.localhost`
- Storage: `http://storage.yii2-starter-kit.localhost`
- Mailcatcher: `http://localhost:1080`

### Manual installation (non-Docker)

1. Create a new project (you can replace `myproject.com` with your preferred folder name):

```bash
composer create-project yii2-starter-kit/yii2-starter-kit myproject.com --ignore-platform-reqs
```

2. Move into the project directory and install dependencies:

```bash
cd myproject.com
taskctl install
```

3. Run setup/build with one of these options:

- Option A:

```bash
taskctl build:env
```

- Option B:

```bash
php console/yii app/setup
npm run build
```

4. Point your web server to these entry points:

- `frontend/web/index.php`
- `backend/web/index.php`
- `api/web/index.php`
- `storage/web/index.php`

## Default accounts

Seed data from migrations includes:

- `administrator`: `webmaster` / `webmaster`
- `manager`: `manager` / `manager`
- `user`: `user` / `user`

## API and Swagger

- Swagger UI: `http://api.yii2-starter-kit.localhost/site/docs`
- OpenAPI JSON: `http://api.yii2-starter-kit.localhost/site/json-schema`
- Active route: `v1/article` (`index`, `view`, `options`)

## Development workflow

Use composer scripts:

```bash
composer docker:start
composer docker:build
composer docker:tests
composer docker:cleanup
```

After `composer docker:tests`, run tests in another terminal:

```bash
docker-compose exec -T console vendor/bin/codecept run
```

## Database utilities

Destructive database reset:

```bash
php console/yii migrate/fresh --interactive=0
php console/yii rbac-migrate/up --interactive=0
```

## Documentation

For more detailed guides, see:

- Installation: [`docs/installation.md`](docs/installation.md)
- Testing: [`docs/testing.md`](docs/testing.md)
- Components and architecture: [`docs/components.md`](docs/components.md)
- Console commands: [`docs/console.md`](docs/console.md)
- FAQ: [`docs/faq.md`](docs/faq.md)

## Notes

- Environment values are loaded from `.env` via `common/env.php` (`env()` helper)
- API routing is defined explicitly in `api/config/_urlManager.php`
- If Linux bind-mount permissions drift, fix permissions for `frontend/runtime`, `frontend/web/assets`, `backend/runtime`, and `backend/web/assets`

## Contribution

Pull requests, issues, and suggestions are welcome.

## License

This project is released under the MIT License. See [LICENSE](LICENSE.md).
