#!/bin/bash

LOG_FILE=/dev/null

date
echo "Starting."

echo ""
date
echo "Installing dependencies. This may take a while on the first run."

bin/composer.sh install &> "$LOG_FILE"

WORK_DIR=${PWD}
PROJECT_NAME=$(basename $WORK_DIR)

echo ""
date
echo "Building docker image. This may take a while on the first run."

docker build --tag "$PROJECT_NAME" docker/php-cli &> "$LOG_FILE"

echo ""
date
echo "Running job."

docker run \
  --rm \
  -v "$WORK_DIR":/app \
  -w /app \
  "$PROJECT_NAME" \
  $*

echo ""
echo ""
date
echo "Claiming ownership of all files."

bin/own.sh ${WORK_DIR}

echo ""
echo ""
date
echo "Script finished."
