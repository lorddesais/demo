#!/usr/bin/env bash

docker build -t demo .
docker run --name=demo -it --rm -p 8000:80 demo /bin/bash
