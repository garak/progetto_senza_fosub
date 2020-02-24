%:
	@:

args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

.PHONY: help start stop console dbupdate load test coverage update asset cs stan npm

help:
	@awk 'BEGIN {FS = ":.*##"; printf "Uso: make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-10s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

start:	## start docker
	docker-compose up -d 

stop: ## stop docker
	docker-compose stop

console: ## execute console with possible parameters
	docker-compose exec php console $(call args,)

dbupdate: ## update database
	docker-compose exec php console do:c:clear-m && docker-compose exec php console do:s:u --force && docker-compose exec phpunit console do:s:u --force

load: ## load fixtures
	docker-compose exec phpunit console do:fi:lo -n

test: ## execute test
	docker-compose exec phpunit phpunit --stop-on-failure

coverage: ## execute test with coverage
	docker-compose exec phpunit phpdbg -qrr bin/phpunit --coverage-html var/build

update: ## update vendor
	docker-compose exec php composer update

asset: ## compile assets
	docker-compose exec php node_modules/.bin/encore dev --watch

cs: ## execute fix coding standard
	docker-compose exec php php-cs-fixer fix -v

stan: ## execute static analysis (requires phpstan locally installed)
	docker-compose exec php bin/phpstan analyse -lmax src tests

npm: ## install frontend dependencies
	docker-compose exec php npm install
