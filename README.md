
#  migrer la DB
docker-compose exec php php bin/console doctrine:migrations:migrate

# Fixtures et stations
docker-compose exec php php bin/console doctrine:fixtures:load

docker-compose exec php php bin/console app:import-station

# Installer bundle emails
docker-compose exec php composer require symfonycasts/verify-email-bundle
