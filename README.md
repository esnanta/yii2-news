Easy to  install, easy to use, hopefuly :p <br>
SEO and Keyword ready.

REQUIREMENT
-------------------
PHP 7.x <br>
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


LICENCE
-------------------
GNU General Public License v3.0 <br>
Do not remove copyright part.   
    

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
