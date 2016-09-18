#!/bin/bash
DOCKER_IMAGE_NAME=apple-availability
docker run \
	--privileged \
	--name $DOCKER_IMAGE_NAME \
	-v `pwd`/app:/app \
	-it \
	--rm \
	--env-file SETTINGS \
	$DOCKER_IMAGE_NAME "$@"