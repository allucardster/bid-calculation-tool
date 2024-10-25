help: ## show this help
	@echo 'usage: make [target] ...'
	@echo ''
	@echo 'targets:'
	@egrep '^(.+)\:\ .*##\ (.+)' ${MAKEFILE_LIST} | sed 's/:.*##/#/' | column -t -c 2 -s '#'
up: ## up all containers
	docker compose up -d
stop: ## stop all containers
	docker compose stop
composer-install: ### install php dependencies
	docker compose exec php sh -c 'composer install'
npm-install: ### install javascript dependencies
	docker compose exec php sh -c 'npm install'
build-frontend: ### build frontend app
	docker compose exec php sh -c 'npm run build'
build: ### build all the necessary for the application run
	make composer-install npm-install build-frontend
test: ### run all the tests
	docker compose exec php sh -c './vendor/bin/phpunit'