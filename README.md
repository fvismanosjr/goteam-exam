# Build & Run (Local)

This file documents the minimal steps to build and run the project (backend + frontend), and explicitly highlights how to use the `UserSeeder` to create initial users.

**Backend (Laravel)**

- Change into the backend folder:

```bash
cd backend
```

- Install PHP dependencies:

```bash
composer install
```

- Create environment file and app key (Windows):

```bash
copy .env.example .env
php artisan key:generate
```

- Edit `.env` to set your database connection values (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

- Run migrations:

```bash
php artisan migrate
```

- Seed users explicitly using the `UserSeeder`:

```bash
php artisan db:seed --class=UserSeeder
```

This will create the user records defined in `UserSeeder`. See the seeder implementation at [backend/database/seeders/UserSeeder.php](backend/database/seeders/UserSeeder.php) and review default credentials before running.

- Alternative: run migrations and all configured seeds together:

```bash
php artisan migrate --seed
# or to reset and re-seed
php artisan migrate:fresh --seed
```

- Serve the app locally:

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

**Backend (Docker Compose)**

If you prefer containers and the repo provides compose setup:

```bash
cd backend
docker compose up -d --build
# then inside the container (replace <service> with the php service name):
docker compose exec <service> php artisan migrate
docker compose exec <service> php artisan db:seed --class=UserSeeder
```

**Frontend (Nuxt)**

- Change into frontend folder and install dependencies (preferred: pnpm):

```bash
cd frontend
pnpm install
pnpm dev
```

If you use npm:

```bash
npm install
npm run dev
```

**Quick checklist / notes**

- Confirm database credentials in `.env` before running migrations/seeds.
- Inspect [backend/database/seeders/UserSeeder.php](backend/database/seeders/UserSeeder.php) to learn what default user(s) it creates and their credentials.
- To recreate the schema + seed: `php artisan migrate:fresh --seed` (destructive).
- If seeding fails due to missing tables, run `php artisan migrate` first.

---
