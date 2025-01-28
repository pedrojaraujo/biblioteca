up:
	docker-compose up -d --build

down:
	docker-compose down

migrate:
	docker-compose exec web php migrations.php

seed:
	docker-compose exec web php migrations.php && php seed.php

logs:
	docker-compose logs -f

composer-install:
	docker-compose exec web composer install

setup: down up migrate
