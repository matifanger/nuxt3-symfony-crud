<h1 align="center">Nuxt 3 - Symfony crud</h1>

## Preview

![image](https://i.imgur.com/TO5qczj.png)

## Setup

### Frontend

```bash
# yarn
yarn install
yarn dev
```

### Backend
```
composer install
```

#### Create new database and modify .env file to setup DATABASE_URL
#### Then:

```
php bin/console doctrine:schema:update --force
symfony server:start
```
