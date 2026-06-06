
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

## Screenshots

See more at:
https://github.com/esnanta/yii2-news/tree/main/screenshots

### Frontend - Home
![Screenshot frontend - Home](https://github.com/esnanta/yii2-news/blob/main/screenshots/home-1.png)

### Backend - Dashboard - article
![Screenshot backend - Dashboard - article](https://github.com/esnanta/yii2-news/blob/main/screenshots/dashboard-2.png)

## Application map

- `frontend/`: public web interface for readers
- `backend/`: admin panel for content and user management
- `console/`: setup, migration, and maintenance commands
- `common/`: shared business logic, models, services, and config
- `storage/`: uploaded files and cache serving

## Requirements (Manual Setup)

- PHP 8.x
- Composer 2.x
- Node.js + npm
- MySQL/MariaDB
- Web server (Nginx/Apache)
- `taskctl` (recommended for shortcut commands)

## Installation

### Manual installation (non-Docker)

1. Clone this repository and enter the project directory:

```bash
git clone https://github.com/esnanta/yii2-news.git
cd yii2-news
```

2. Install dependencies:

```bash
taskctl install
```

3. Create `.env`:

```bash
cp .env.dist .env
```

4. Run application setup and build frontend/backend bundles:

```bash
taskctl local:build
```


If `taskctl` is not available, use this fallback for dependency installation:

```bash
composer install
npm install
```

Then continue with environment setup and build:

```bash
cp .env.dist .env
php console/yii app/setup --interactive=0
npm run build
```

> Note: `taskctl install` only installs dependencies (`composer install` + `npm install`).
> Then run `cp .env.dist .env` and `taskctl local:build`.

## Default accounts

Seed data from migrations includes:

- `administrator`: `webmaster` / `webmaster`
- `manager`: `manager` / `manager`
- `user`: `user` / `user`

## Shared Hosting Deployment

This deployment path assumes you have terminal access on your hosting server.

### Prerequisites

Install these tools first:

- Composer: [`docs/hosting/install_composer`](docs/hosting/install_composer)
- Node.js: [`docs/hosting/install_nodejs`](docs/hosting/install_nodejs)
- taskctl: [`docs/hosting/install_taskctl`](docs/hosting/install_taskctl)

### Deploy steps

1. Use your hosting Git menu/tooling to pull this repository:

`https://github.com/esnanta/yii2-news`

Most shared hosting setups place it under:

`~/repositories/yii2-news`

2. Use terminal and run deployment pipeline:

```bash
cd ~/repositories/yii2-news
taskctl -c taskctl.hosting.yaml hosting:deploy
```

3. If deployment succeeds, your hosting directory structure should match:

[`docs/hosting/directory-example`](docs/hosting/directory-example)

4. Configure `.env` in `~/repositories/yii2-news/.env` (adjust values for your domain):

```dotenv
YII_DEBUG=0
YII_ENV=prod
APP_MAINTENANCE=0

FRONTEND_HOST_INFO=https://example.com
FRONTEND_BASE_URL=/news
BACKEND_HOST_INFO=https://example.com
BACKEND_BASE_URL=/news/backend
STORAGE_HOST_INFO=https://example.com
STORAGE_BASE_URL=/news/storage
```

You can use this file as a reference template:

[`docs/hosting/directory-example/repositories/yii2-news/env-example`](docs/hosting/directory-example/repositories/yii2-news/env-example)

## Documentation

For more detailed guides, see:

- Installation: [`docs/installation.md`](docs/installation.md)
- Testing: [`docs/testing.md`](docs/testing.md)
- Components and architecture: [`docs/components.md`](docs/components.md)
- Console commands: [`docs/console.md`](docs/console.md)
- FAQ: [`docs/faq.md`](docs/faq.md)
- Hosting directory reference: [`docs/hosting/hosting-directory.md`](https://github.com/esnanta/yii2-news/blob/main/docs/hosting/hosting-directory.md?plain=1)

## Notes

- Environment values are loaded from `.env` via `common/env.php` (`env()` helper)

## Contribution

Pull requests, issues, and suggestions are welcome.

## License

This project is released under the MIT License. See [LICENSE](LICENSE.md).