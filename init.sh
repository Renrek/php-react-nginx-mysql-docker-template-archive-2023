#!/bin/sh
echo "Installing Composer"
docker exec -i php composer install
echo "Installing Node Modules"
docker exec -i php npm install