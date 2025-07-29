up:
	docker compose -f .cd/docker-compose.yml up -d --build

down:
	docker compose -f .cd/docker-compose.yml down

restart:
	docker compose -f .cd/docker-compose.yml down && docker compose -f .cd/docker-compose.yml up -d --build

logs:
	docker compose -f .cd/docker-compose.yml logs -f

artisan:
	docker compose -f .cd/docker-compose.yml exec app php artisan $(cmd)

composer:
	docker compose -f .cd/docker-compose.yml exec app composer $(cmd)

migrate:
	docker compose -f .cd/docker-compose.yml exec app php artisan migrate

seed:
	docker compose -f .cd/docker-compose.yml exec app php artisan db:seed

bash:
	docker compose -f .cd/docker-compose.yml exec app bash

mysql:
	docker compose -f .cd/docker-compose.yml exec mysql mysql -u$$DB_USERNAME -p$$DB_PASSWORD $$DB_DATABASE

redis:
	docker compose -f .cd/docker-compose.yml exec redis redis-cli

test:
	docker compose -f .cd/docker-compose.yml exec app php artisan test

nginx-reload:
	docker compose -f .cd/docker-compose.yml exec nginx nginx -s reload

phpmyadmin:
	docker compose -f .cd/docker-compose.yml exec phpmyadmin bash

create-admin:
	docker compose -f .cd/docker-compose.yml exec app php artisan tinker --execute="\\App\\Models\\User::updateOrCreate(['email' => 'admin@admin.com'], ['name' => 'Admin', 'password' => bcrypt('admin123'), 'role' => 'admin'])"

create-customer:
	docker compose -f .cd/docker-compose.yml exec app php artisan tinker --execute="\App\Models\User::updateOrCreate(['email' => 'customer@customer.com'], ['name' => 'Customer', 'password' => bcrypt('customer123'), 'role' => 'customer'])"
