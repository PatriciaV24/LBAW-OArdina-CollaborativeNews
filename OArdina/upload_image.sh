#!/bin/bash

# Stop execution if a step fails
set -e

IMAGE_NAME=git.fe.up.pt:5050/lbaw/lbaw2122/lbaw2163 

# Ensure that dependencies are available
composer install
php artisan clear-compiled
php artisan optimize

sudo docker build -t $IMAGE_NAME .
sudo docker push $IMAGE_NAME
