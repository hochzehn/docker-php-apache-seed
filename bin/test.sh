#!/bin/bash

# Usage:
# bin/test.sh [params]
#

BUILD_LOG_FILE=/dev/null
TEST_LOG_FILE=var/test.log

date
echo "Starting."

echo ""
date
echo "Installing dependencies. This may take a while on the first run."

bin/composer.sh install &> "$BUILD_LOG_FILE"

WORK_DIR=${PWD}
PROJECT_NAME=$(basename $WORK_DIR)

echo ""
date
echo "Building docker image. This may take a while on the first run."

docker build --tag "$PROJECT_NAME" docker/php-cli &> "$BUILD_LOG_FILE"

echo ""
date
echo "Running tests."

docker run \
  --rm \
  -v "$WORK_DIR":/app \
  -w /app \
  --entrypoint "/app/vendor/bin/phpunit" \
  "$PROJECT_NAME" \
  --stderr --color $@ 2>&1 | tee "$TEST_LOG_FILE"
