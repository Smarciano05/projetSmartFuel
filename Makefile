# Path to the docker-compose file
DOCKER_COMPOSE_FILEPATH=.docker/docker-compose.yaml
DOCKER_PHP_CONTAINER=smartfuel_php

# Start the containers in the background
up:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) up -d

# Stop the containers
down:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) down

# Recreate the containers (useful after modifying the Dockerfile)
build:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) up --build -d

# View the logs of the containers
logs:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) logs -f

# View the status of the containers
status:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) ps

# Remove the containers, networks, volumes, and images created by up
clean:
	docker compose -f $(DOCKER_COMPOSE_FILEPATH) down --volumes --remove-orphans

# Restart the containers
restart: down up

# Connect to the PHP container
shell:
	docker exec -it $(DOCKER_PHP_CONTAINER) /bin/bash

# Run composer install
composer-install:
	docker exec $(DOCKER_PHP_CONTAINER) composer install

# Regenerate Composer autoloading
dump-autoload:
	docker exec $(DOCKER_PHP_CONTAINER) composer dump-autoload

# Run Symfony console commands
sf:
	docker exec $(DOCKER_PHP_CONTAINER) php bin/console

# Clear the Symfony cache
cache-clear:
	docker exec $(DOCKER_PHP_CONTAINER) php bin/console cache:clear

# Run database migrations
migrate:
	docker exec $(DOCKER_PHP_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction

# Run PHPUnit tests
test:
	docker exec $(DOCKER_PHP_CONTAINER) ./vendor/bin/phpunit
	
security:
	enable_authenticator_manager: true
	# https://symfony.com/doc/current/security.html#registering-the-user-hashing-passwords
	password_hashers:
		Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
	# https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
	providers:
		users_in_memory: { memory: null }
	firewalls:
		dev:
			pattern: ^/(_(profiler|wdt)|css|images|js)/
			security: false
		main:
			lazy: true
			provider: users_in_memory

			# activate different ways to authenticate
			# https://symfony.com/doc/current/security.html#firewalls-authentication

			# https://symfony.com/doc/current/security/impersonating_user.html
			# switch_user: true

	# Easy way to control access for large sections of your site
	# Note: Only the *first* access control that matches will be used
	access_control:
		# - { path: ^/admin, roles: ROLE_ADMIN }
		# - { path: ^/profile, roles: ROLE_USER }