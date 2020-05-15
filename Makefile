init: docker-down-clear \
	 api-clear docker-build docker-up \
	 api-init
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-build:
	docker-compose build

api-clear:
	docker run --rm -v ${PWD}/:/app -w /app alpine sh -c 'rm -rf var/cache/* var/log/*'

api-init: api-composer-install api-wait-db api-migrations api-fixtures

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-wait-db:
	sleep 10
	#until docker-compose exec -T mysql mysqladmin ping ; do sleep 20 ; done

api-migrations:
	docker-compose run --rm api-php-cli php bin/console doctrine:migrations:migrate --no-interaction

api-validate-schema:
	docker-compose run --rm api-php-cli php bin/console doctrine:schema:validate

api-fixtures:
	docker-compose run --rm api-php-cli php bin/console doctrine:fixtures:load --no-interaction