# DEVELOPMENT
build:
	docker compose -f docker-compose.development.yml build --pull --no-cache

up:
	docker compose -f docker-compose.development.yml up -d

down:
	docker compose -f docker-compose.development.yml down

destroy:
	docker compose -f docker-compose.development.yml down -v

bash:
	docker compose -f docker-compose.development.yml exec backend sh

tinker:
	docker compose -f docker-compose.development.yml exec backend php artisan tinker

migrate:
	docker compose -f docker-compose.development.yml exec backend php artisan migrate $(filter-out $@,$(MAKECMDGOALS))

create-migration:
	docker compose -f docker-compose.development.yml exec backend php artisan make:migration $(filter-out $@,$(MAKECMDGOALS))

nginx-logs:
	docker compose -f docker-compose.development.yml logs -f nginx -n 0

nginx-reload:
	docker compose -f docker-compose.development.yml exec nginx nginx -s reload

worker-logs:
	docker compose -f docker-compose.development.yml logs -f worker -n 0

test:
	docker compose -f docker-compose.development.yml exec backend php artisan test



