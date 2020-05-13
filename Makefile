init: docker-down-clear \
	 api-clear docker-pull docker-build docker-up \
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

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

api-clear:
	docker run --rm -v ${PWD}/api:/app -w /app alpine sh -c 'rm -rf var/cache/* var/log/*'

api-init: api-composer-install api-wait-db api-migrations

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-wait-db:
	until docker-compose exec -T sm-postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

api-migrations:
	docker-compose run --rm api-php-cli php bin/console doctrine:migrations:migrate --no-interaction

api-validate-schema:
	docker-compose run --rm api-php-cli php bin/console doctrine:schema:validate
