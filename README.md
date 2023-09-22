# iLogix

## Install

```sh
#clone the project to download its contents
$ cd ilogix/
$ git clone ...

#make Composer install the project's dependencies into vendor/
$ composer install
```

## Utils

```sh
# info project
php bin/console about

# clear cache
php bin/console cache:clear

composer dump-autoload
```

## Running

```sh
# use symfony CLI
$ symfony server:start

# use PHP
php -S localhost:8080 -t public/
```

### Migration

Após criar uma nova Entity será necessário criar uma nova migration e executá-la.

```sh
# create migration
php bin/console doctrine:migrations:diff #default
php bin/console doctrine:migrations:diff --em=compras #compras

# Run migration
php bin/console doctrine:migrations:migrate

```
