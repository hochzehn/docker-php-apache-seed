#!/bin/bash

DIR=$1

docker run \
  --rm \
  -v ${DIR}:/app \
  alpine \
  chown -R $(id -u):$(id -g) /app
