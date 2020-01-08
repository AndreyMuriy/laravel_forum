permission:
	sudo chmod 777 storage -R

build:
	docker-compose -f docker/docker-compose.yml up --build -d

up:
	docker-compose -f docker/docker-compose.yml up -d

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

part:
	docker exec forum_php-fpm php artisan $(c)

npm-install:
	docker-compose -f docker/docker-compose.yml run node npm install

npm-dev:
	docker-compose -f docker/docker-compose.yml run node npm run dev
