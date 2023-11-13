# Base Symfony

## Install without Docker

```sh
#clone the project to download its contents
cd ilogix/
git clone ...

# make Composer install the project's dependencies into vendor/
composer install

# run migrations
php bin/console doctrine:migrations:migrate

# container -> run fixtures
php bin/console doctrine:fixtures:load

# RUNNING
# use symfony CLI
symfony server:start

# or use PHP
php -S localhost:8080 -t public/
```

## Install with Docker

```sh
#clone the project to download its contents
cd ilogix/
git clone ...

docker-compose build

docker compose up -d

# container > install composer
composer install

# container > run migrations
php bin/console doctrine:migrations:migrate

# container -> run fixtures - DADOS PARA TESTE **********
php bin/console doctrine:fixtures:load
```

## Config

> Criar um aquivo .env.local e adicionar as configurações locais (uma cópia do .env)

```sh
DATABASE_URL=
DATABASE_COMPRAS_URL=

...
```

## Create New Migration

> Após criar uma nova Entity será necessário criar uma nova migration e executá-la. [Link](https://symfony.com/doc/current/doctrine/multiple_entity_managers.html).

```sh
# create or update entity in migration
php bin/console doctrine:migrations:diff --em=default #default
php bin/console doctrine:migrations:diff --em=compras #compras

# run migration
php bin/console doctrine:migrations:migrate
```

## Utils

```sh
# info project
php bin/console about

# clear cache
php bin/console cache:clear

composer dump-autoload
```
## react client
> requires node node and npm

```sh
cd client/

#once time
npm install 

npm start
 ```
