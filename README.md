# Google Translate Proxy

Translates text into different languages using Google Translate API.

Stores translated text in the database in order to reduce the amount of Google API calls ($$$)  

## Installation

```bash
cp -n ./.env.dist ./.env
cp -n ./.docker.env.local.dist ./.docker.env.local
docker-compose up -d
docker-compose exec web composer install
docker-compose exec web bin/console doctrine:migrations:migrate
```
