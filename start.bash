#!/usr/bin/env bash

echo "Welcome in docker container with demo app!"
echo "Run the app with 'php index.php <entity_type> <entity_id> <entity_relation>' e.g. 'php index.php user 1 post'"
docker run -it demo /bin/bash
