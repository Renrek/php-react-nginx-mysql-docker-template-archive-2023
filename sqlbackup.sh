#!/bin/sh
docker exec -it mysql mysqldump -u root -psecret template > bkup.sql