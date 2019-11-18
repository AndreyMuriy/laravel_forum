init:
	cp .env.example .env
	cp docker/services/nginx/default.conf.example docker/services/nginx/default.conf
	cp docker/services/php-fpm/php.ini.example docker/services/php-fpm/php.ini
	cp docker/docker-compose.yml.example docker/docker-compose.yml

permission:
	sudo chmod 777 storage -R

up:
	docker-compose -f docker/docker-compose.yml up --build -d

down:
	docker-compose -f docker/docker-compose.yml down

bash-php:
	docker exec -it forum_php-fpm bash

composer-install:
	docker exec forum_php-fpm composer install

key-generate:
	docker exec forum_php-fpm php artisan key:generate

migrate:
	docker exec forum_php-fpm php artisan migrate
