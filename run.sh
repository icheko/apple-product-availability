#!/bin/bash
DOCKER_IMAGE_NAME=apple-availability
docker run \
	--name $DOCKER_IMAGE_NAME \
	-v `pwd`/app:/app \
	-it \
	--rm \
	--env-file SETTINGS \
	$DOCKER_IMAGE_NAME "$@"