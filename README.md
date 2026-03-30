
#  migrer la DB
 php bin/console doctrine:migrations:migrate

# Fixtures et stations
 php bin/console doctrine:fixtures:load

 php bin/console app:import-station

# Installer bundle emails
composer require symfonycasts/verify-email-bundle
