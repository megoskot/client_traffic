#!/bin/sh -ex

composer install
docker-compose -f docker-compose.yml up -d
php bin/console doctrine:migrations:migrate