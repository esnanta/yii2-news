/home/your-username
│
├── public_html
│   └── news
│       ├── .htaccess                       # copied from repository root
│       ├── backend
│       │   └── web                         # copied from repositories/yii2-news/backend/web
│       │       ├── index.php               # replaced from index-hosting.php during deploy
│       │       ├── .htaccess
│       │       ├── assets
│       │       ├── bundle
│       │       ├── css
│       │       ├── img
│       │       └── js
│       ├── frontend
│       │   └── web                         # copied from repositories/yii2-news/frontend/web
│       │       ├── index.php               # replaced from index-hosting.php during deploy
│       │       ├── .htaccess
│       │       ├── assets
│       │       ├── bundle
│       │       ├── css
│       │       ├── img
│       │       ├── js
│       │       └── themes
│       └── storage
│           ├── cache -> $HOME/repositories/yii2-news/storage/cache
│           └── web                         # copied from repositories/yii2-news/storage/web
│               ├── index.php               # replaced from index-hosting.php during deploy
│               ├── .htaccess
│               └── source -> $HOME/repositories/yii2-news/storage/web/source
│
└── repositories
    └── yii2-news
        ├── .git
        ├── .github
        ├── .idea
        ├── .env
        ├── api
        ├── backend
        │   ├── runtime                     # writable, used directly from repository
        │   └── web
        ├── common
        ├── console
        ├── deploy
        ├── docker
        ├── docs
        ├── frontend
        │   ├── runtime                     # writable, used directly from repository
        │   └── web
        ├── node_modules
        ├── storage
        │   ├── cache                       # writable, symlink target in public_html/news/storage/cache
        │   ├── config
        │   └── web
        │       └── source                  # writable, symlink target in public_html/news/storage/web/source
        ├── tests
        ├── vendor
        ├── composer.json
        ├── composer.lock
        ├── package.json
        ├── package-lock.json
        ├── taskctl.hosting.yaml
        └── ...