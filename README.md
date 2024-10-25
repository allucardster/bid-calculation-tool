Bid Calculation Tool
======

Requirements
============
- Docker (>= 27.x)
- Docker Compose (>= 2.x)
- Make (optional)

Technology Stack
================
- Composer 2.8.1
- PHP 8.1.x
- Symfony 6.4
- Vue 3.5.x
- node 18.19.x
- npm 9.2.0
- Nginx latest

Setup
=====
- Setup default enviroment variables
```shell
cp .env.example .env
``` 
- Init docker containers
```shell
## Using make
make up
## Otherwise
docker compose up -d
```
- Build application
```shell
## Using make
make build
## Other wise
docker compose exec php sh -c 'composer install'
docker compose exec php sh -c 'npm install'
docker compose exec php sh -c 'npm run build'
```
- In a web browser open the following url:
```shell
http://localhost:8080
```
- Enjoy!

Testing
=======
- To execute the test use:
```shell
## Using make
make test
## Other wise
docker compose exec php sh -c './vendor/bin/phpunit'
```

Troubleshooting
================

_When init the containers receive a `Bind for 0.0.0.0:8080 failed: port is already allocated` error._

To solve this, just open the `.env` file and change the environment variable `APP_PORT` to some port number that is not `allocated` to other service.

Contributors
============
- Richard Melo [Github](https://github.com/allucardster), [Linkedin](https://www.linkedin.com/in/richardmelo)
