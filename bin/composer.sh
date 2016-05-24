#!/bin/bash

CMD=$1
if [ -z "$CMD" ]; then
  CMD="install"
fi

WORK_DIR=${PWD}

docker run \
  --rm \
  -v ${WORK_DIR}:/app \
  -w /app \
  composer/composer:1.1-alpine \
  $CMD

bin/own.sh ${WORK_DIR}
