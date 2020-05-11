up:
	docker-compose up

composer-install:
	docker-compose exec php composer install

init-database:
	docker-compose exec php bin/console doctrine:database:drop --if-exists --force --no-interaction
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:schema:update --force
