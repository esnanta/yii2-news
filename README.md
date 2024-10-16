<p>
  This is an open-source project aimed at providing a simple, flexible platform for managing news articles and content. The application includes features for managing articles, authors, staff, assets, and layout customization.
</p>
<h2>
  Features
</h2>
<ul>
  <li>
    <strong>
      Articles:
    </strong>
    Create, edit, and manage news articles.
  </li>
  <li>
    <strong>
      Authors:
    </strong>
    Assign authors to articles and manage author information
  </li>
  <li>
    <strong>
      Assets:
    </strong>
    Upload and manage documents or images, with the option to set them as public or private.
  </li>
  <li>
    <strong>
      Layout :
    </strong>
    Customize the appearance of the site by uploading logos and banners.
  </li>
</ul>
<p>
  The application provides two layouts:
</p>
<ul>
  <li>
    <strong>
      Frontend:
    </strong>
    A public-facing interface for readers to view news articles and other content.
  </li>
  <li>
    <strong>
      Backend:
    </strong>
    A secure admin panel for managing articles, assets, staff, and more.
  </li>
</ul>
<h2>
  Getting Started
</h2>
<p>
  To get started with the project, please follow the installation instructions below. Contributions, suggestions, and feedback are all welcome. We’re excited to see how the community uses and improves this project!
</p>

REQUIREMENT
-------------------
PHP 8.x <br>
Composer 2.x <br>

INSTALLATION
-------------------
composer create-project esnanta/yii2-news

environment:<br>
in command do "php init" and choose development or production.<br>
1. if you choose development, update composer package:<br>
composer update<br>
<br>
or 2. production:<br>
composer update --no-dev<br>


DIRECTORY STRUCTURE
-------------------

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
