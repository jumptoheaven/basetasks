LOCAL_UID=$$(id -u)
DOCKER_CMD=sudo HOST_UID=$(LOCAL_UID) docker-compose -p yurich-integer-hash-storage -f "$$PWD/docker-compose.yml"

list:
	cat Makefile | grep -E '^([A-Za-z\\\\-]+):( |$$)' | sed "s/:.*//g" # Список правил. кривовато, но пусть так хотя бы


build:
	$(DOCKER_CMD) up -d --force-recreate --build
start:
	$(DOCKER_CMD) start
stop:
	$(DOCKER_CMD) stop
up:
	$(DOCKER_CMD) up
up-daemon:
	$(DOCKER_CMD) up
down:
	$(DOCKER_CMD) down
show-logs:
	$(DOCKER_CMD) logs --tail=50 -f
php-console:
	$(DOCKER_CMD) exec php bash
php-composer-install:
	$(DOCKER_CMD) exec php composer.phar install
php-composer-update:
	$(DOCKER_CMD) exec php composer.phar install
phpcs:
	$(DOCKER_CMD) exec php ./vendor/bin/phpcs --standard=PSR12 ./src/
phpcbf:
	$(DOCKER_CMD) exec php ./vendor/bin/phpcbf --standard=PSR12 ./src/
