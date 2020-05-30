#!/bin/bash

set -eufo pipefail

SOURCE="${BASH_SOURCE[0]}"
while [ -h "$SOURCE" ]; do
	DIR="$(cd -P "$(dirname "$SOURCE")" > /dev/null 2>&1 && pwd)"
	SOURCE="$(readlink "$SOURCE")"
	[[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE"
done
DIR="$(cd -P "$(dirname "$SOURCE")" > /dev/null 2>&1 && pwd)"

CACHE_TAG=$(git describe --abbrev=0 --tags | sed 's/^v//')
DOCKERFILE_PATH="Dockerfile"
SOURCE_COMMIT=$(git rev-parse --short HEAD)
export CACHE_TAG DOCKERFILE_PATH SOURCE_COMMIT

(export IMAGE_NAME=nfarrington/vats.im-nginx:${CACHE_TAG} TARGET=nginx &&
	echo "Building $IMAGE_NAME" &&
	./hooks/build)
(export IMAGE_NAME=nfarrington/vats.im-php-fpm:${CACHE_TAG} TARGET=php-fpm &&
	echo "Building $IMAGE_NAME" &&
	./hooks/build)
