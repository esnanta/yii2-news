# Yii2 News Management System

![GitHub version](https://img.shields.io/github/v/tag/esnanta/yii2-news?label=version&color=blue)
![License](https://img.shields.io/github/license/esnanta/yii2-news?color=green)
![PHP](https://img.shields.io/badge/PHP-8.x-blue)

This is an **open-source project** aimed at providing a **simple, flexible platform** for managing news articles and content. The application includes features for managing articles, authors, staff, assets, and layout customization.

## Features

- **Articles**: Create, edit, and manage news articles.
- **Authors**: Assign authors to articles and manage author information.
- **Assets**: Upload and manage documents or images, with the option to set them as public or private.
- **Layout**: Customize the site's appearance by uploading logos and banners.

The application provides two layouts:
- **Frontend**: Public-facing interface for readers to view news articles and content.
- **Backend**: Secure admin panel for managing articles, assets, staff, and more.

## Requirements

- PHP 8.x
- Composer 2.x
- MySQL / MariaDB

## Installation

Follow these steps to set up the project on your local environment:

1. **Clone or Create Project**
    ```bash
    composer create-project esnanta/yii2-news
    ```

2. **Initialize Environment**
    ```bash
    php init
    ```
   Select either `development` or `production`.

3. **Install Composer Dependencies**
    - For development:
      ```bash
      composer update
      ```
    - For production:
      ```bash
      composer update --no-dev
      ```

4. **Create Database**
    - Create a MySQL database (e.g., `yii2_news`).
    - Configure your database connection in:
      ```
      common/config/main.php
      ```
      or environment-specific:
      ```
      environments/dev/common/config/main-local.php
      ```
      according to your database credentials.

5. **Run Database Initialization**
    ```bash
    php yii db/create
    ```
   This will create the necessary database structure if configured.

6. **Run Migrations**
    ```bash
    php yii migrate
    ```
   This will create all required tables and apply initial schema.

7. **Set Writable Permissions**
   Ensure the following directories are writable:
    - `backend/web/assets`
    - `frontend/web/assets`
    - `backend/runtime`
    - `frontend/runtime`
    - `common/runtime`

8. **Run the Application**
    - For the backend:
      Open in browser:
      ```
      http://localhost/yii2-news/backend/web
      ```
    - For the frontend:
      Open in browser:
      ```
      http://localhost/yii2-news/frontend/web
      ```

## Directory Structure

```
assets
    sql/                 sql for database
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
common
    config/              contains shared configurations
    config/main.php      app and database configuration
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    widgets/             contains app widgets   
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```


## Contribution

Contributions, suggestions, and feedback are welcome! Feel free to submit pull requests or open issues to improve this project.

---