# Test Back-End API Laravel Intranet Inside
 
### Description
Dans le cadre d'un test technique pour la société Intranet Inside, j'ai travaillé sur une petite API avec le framework Laravel version 9.19.0 sous Docker. 

### Lancer le projet
- Require PHP 8.1 -
sudo apt-get install php-dom php-xml php-curl
cd backend && composer install

### Run Locally

Clone the project

```bash
 git@github.com:gaoubak/test-intranet-inside.git
```

Run the docker-compose

```bash
  docker compose build --no-cache --pull
```
```bash
 docker-compose up -d
```
```
Log into the PHP container

```bash
  docker exec -it  nom-du-container bash
```


## Ready to use with

This docker-compose provides you :

- PHP-8.1-fpm 
    - Composer
    - git , curl , libpq-dev , libpng-dev , libonig-dev , libxml2-dev , zip , unzip
- adminer
- db
- nginx
