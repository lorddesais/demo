#!/usr/bin/env bash

echo "Building docker container..."
docker build -t demo .

docker-compose up -d
echo "DONE! Container is ready to use!"