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
1. In frontend/ directory, add environment variable `VITE_APP_BASE_API_URL` for API calls in a .env file. 
2. Set the value to the exposed url of the running backend/ application with the format `${exposed URL}/api/`. Example: `https://6x3dfh-8000.csb.app/api/`, `http://127.0.0.1:8000/api`, or refer to .env-example
3. In backend/ directory, add environment variable for postgres sql connection in a .env file.
4. Add these below environment variables into the .env file in backend/ directory:
   ` DB_CONNECTION=pgsql`
   ` DB_HOST=127.0.0.1`
   ` DB_PORT=5500`
   ` DB_DATABASE=example_app_db`
   ` DB_USERNAME=veve`
   ` DB_PASSWORD=veve`