# task-management-system

This repo contains both backend and frontend.

Start backend/
1. Pre-requisite: **Docker, php, composer**
2. For starting Laravel backend, got to backend/ directory, run `./start-postgres.sh` to boot up postgres DB.
3. Run `composer run dev`.
4. If its the first time to startup backend/, its required to run `composer install`.
5. Run `php artisan db:seed` if required to create initial users and randomized tasks data.

Start frontend/
1. Pre-requisite: **Node.js, npm**
2. For starting Vue.js frontend, got to frontend/ directory and run `npm run dev` command.
3. If its the first time to startup frontend/, its required to run `npm install`.

**Note:** 
1. In frontend/ directory, add environment variable `VITE_APP_BASE_API_URL` for API calls. 
2. Set the value to the exposed url of the running backend/ application with the format `${exposed URL}/api/`. Example: `https://6x3dfh-8000.csb.app/api/`, or refer to .env-example