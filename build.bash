#!/usr/bin/env bash

echo "Installing composer dependencies..."
cd app
composer install

echo "Building docker container..."
cd ..
docker build -t demo .

docker-compose up -d
echo "DONE! Container is ready to use!"