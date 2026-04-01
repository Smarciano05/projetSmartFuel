
#  migrer la DB
 php bin/console doctrine:migrations:migrate

 # si migration deja faite et il y a un bug 
 php bin/console doctrine:migrations:version DoctrineMigrations\\Version000000 --add
 (mettre le numero de la version à la place des zero)


# Fixtures et stations
 php bin/console doctrine:fixtures:load

 php bin/console app:import-station

# Installer bundle emails
composer require symfonycasts/verify-email-bundle

