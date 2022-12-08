up: clean_containers
	./vendor/bin/sail up -d --build --remove-orphans -d

down:
	./vendor/bin/sail down

stop:
	./vendor/bin/sail stop

clean_containers:
	docker stop $$(docker ps -aq) || true

bash:
	docker-compose exec -it $(app) bash

start: clean_directories create_env composer_install down clean_images up npm_install migrate_up welcome run_ui

restart: create_env composer_sail_install down up npm_install migrate_up welcome run_ui

composer_sail_install:
	docker-compose exec laravel.test composer install

composer:
	docker-compose exec laravel.test composer ${CMD}

create_migration:
	./vendor/bin/sail php artisan make:migration ${name}

migrate_up:
	./vendor/bin/sail php artisan migrate

migrate_down:
	./vendor/bin/sail php artisan migrate:rollback

create_model:
	php artisan make:model ${model} -m

welcome:
	@echo "\n\nStarting development server at http://localhost/"
	@echo "\nTo Quit, use the command 'make down'\n\n"

npm_install:
	./vendor/bin/sail npm install

run_ui:
	./vendor/bin/sail npm run dev

test:
	vendor/bin/phpunit

composer_install:
	composer install || true

create_env:
	[ -f ".env" ] || cp .env.example .env


clean_images:
	docker image prune -f -a || true

clean_directories:
	rm -rf package-lock.json
	rm -rf composer.lock
	rm -rf vendor
	rm -rf node_modules

