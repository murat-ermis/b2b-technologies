up:
	docker compose -f .cd/docker-compose.yml up -d --build

down:
	docker compose -f .cd/docker-compose.yml down

restart:
	docker compose -f .cd/docker-compose.yml down && docker compose -f .cd/docker-compose.yml up -d --build

logs:
	docker compose -f .cd/docker-compose.yml logs -f

artisan:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app php artisan $(cmd)

composer:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app composer $(cmd)

migrate:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app php artisan migrate

seed:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app php artisan db:seed

bash:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app bash

mysql:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-mysql mysql -u$$DB_USERNAME -p$$DB_PASSWORD $$DB_DATABASE

redis:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-redis redis-cli

test:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app php artisan test

nginx-reload:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-nginx nginx -s reload

phpmyadmin:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-phpmyadmin bash

create-admin:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app php artisan tinker --execute="\\App\\Models\\User::updateOrCreate(['email' => 'admin@admin.com'], ['name' => 'Admin', 'password' => bcrypt('admin123'), 'role' => 'admin'])"

create-customer:
	docker compose -f .cd/docker-compose.yml exec b2b-technologies-app php artisan tinker --execute="\App\Models\User::updateOrCreate(['email' => 'customer@customer.com'], ['name' => 'Customer', 'password' => bcrypt('customer123'), 'role' => 'customer'])"
