#!/bin/bash

# IMPORTANT: If you change a value of these properties, please update the documentation in the README file
# Please choose an appropriate image tag from the official repository https://hub.docker.com/_/postgres/
containerName=postgresql_test_laravel
dbVersion="14-alpine"
dbName=example_app_db
dbUser=veve
dbPass=veve

# Run the docker container for PostgreSQL and start php artisan migrate
echo -e "\\nStarting docker container postgresql...\\n"

docker run --rm --name ${containerName} -e POSTGRES_PASSWORD=${dbPass} -e POSTGRES_USER=${dbUser} -e POSTGRES_DB=${dbName}  -d -p 127.0.0.1:5500:5432 postgres:${dbVersion}
sleep 5
php artisan migrate

echo -e "\\nTo stop the database, execute: docker stop ${containerName}\\n"
