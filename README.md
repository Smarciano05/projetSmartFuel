
#  migrer la DB
 php bin/console doctrine:migrations:migrate

 # si migration deja faite et il y a un bug 
 php bin/console doctrine:migrations:version DoctrineMigrations\\Version000000 --add
 (mettre le numero de la version à la place des zero)


# commande pour importer les stations et le carburant
php bin/console app:import-station                                                                                                                      
php bin/console app:import-stock-csv public/data/stockcarburant.csv
 

# Installer bundle emails
composer require symfonycasts/verify-email-bundle

