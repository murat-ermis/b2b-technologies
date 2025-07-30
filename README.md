# B2B Technologies

This project is a Laravel-based application, fully containerized with Docker to streamline modern development workflows.

## Project Foundation & Infrastructure

The project runs on a Docker architecture with the following main services:

- **php:8.2-fpm**: Runs the Laravel application using PHP 8.2 FPM.
- **nginx**: Serves as the web server, integrated with PHP-FPM.
- **mysql**: MySQL is used as the database, with persistent storage via Docker volumes.
- **redis**: Used by Laravel for cache management.
- **phpmyadmin**: Provides a web interface for managing the MySQL database.

All services are orchestrated via `docker-compose.yml` and communicate over an isolated Docker network. Makefile commands automate setup and management for a fast and consistent development environment.

## Setup Steps

### 1. Clone the Repository

```bash
git clone <repo-url>
cd b2b-technologies
```

### 2. Create the Environment File

```bash
cp .env.example .env
```

### 3. Configure Database Settings

Update your database credentials in the `.env` file.

### 4. Generate Application Key

```bash
make artisan cmd="key:generate"
```

### 5. Start Services with Docker & Makefile

```bash
make up
```

### 6. Install Composer Dependencies

```bash
make composer cmd=install
```

### 7. Run Database Migrations

```bash
make migrate
```

### 8. Seed Test Data (Optional)

```bash
make seed
```

### 9. Access the Application

The project will be ready to use at: [http://localhost:8080](http://localhost:8080)

---

## Makefile Commands

Below are all available Makefile commands for this project:

- Start services:
  ```bash
  make up
  ```
- Stop services:
  ```bash
  make down
  ```
- Restart services:
  ```bash
  make restart
  ```
- View logs:
  ```bash
  make logs
  ```
- Run artisan commands:
  ```bash
  make artisan cmd="<command>"
  ```
- Run composer commands:
  ```bash
  make composer cmd=<command>
  ```
- Run migrations:
  ```bash
  make migrate
  ```
- Run seeders:
  ```bash
  make seed
  ```
- Open bash in the app container:
  ```bash
  make bash
  ```
- Connect to MySQL terminal:
  ```bash
  make mysql
  ```
- Connect to Redis CLI:
  ```bash
  make redis
  ```
- Run tests:
  ```bash
  make test
  ```
- Reload Nginx:
  ```bash
  make nginx-reload
  ```
- Connect to PhpMyAdmin container:
  ```bash
  make phpmyadmin
  ```
- Create an admin user:
  ```bash
  make create-admin
  ```
- Create a customer user:
  ```bash
  make create-customer
  ```

See the Makefile for details on each command.

---

## API Testing & Postman Collection

To easily test API requests, a `B2B Technologies.postman_collection.json` file is provided in the project root. You can import this file into Postman to quickly access and test all endpoints:

- In Postman, click "Import".
- Select the `B2B Technologies.postman_collection.json` file and import it.
- Set any required environment variables (e.g., `baseURL`) and start using the API requests.

---

## Additional Information

- Laravel documentation: [https://laravel.com/docs](https://laravel.com/docs)
- For issues: [issue tracker](https://github.com/<repo>/issues)

---

For any questions, please contact the project maintainer.
