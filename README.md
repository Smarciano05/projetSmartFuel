#🚀 Projet SmartFuel

## 👥 Membres de l'équipe

    Mariam Sidiki Diawara : diawaramariamsidiki@gmail.com
    Shirel Marciano : shirel.marciano05@gmail.com
    Sarah Marecar : marecarsarah@gmail.com

## 📌 Description du projet

Smart Fuel est une plateforme web de gestion intelligente du carburant conçue pour aider les stations-service et les clients à mieux gérer les périodes de pénurie au Mali.

Côté client, les utilisateurs peuvent consulter les stations disponibles sur une carte, voir l’historique de leurs prises d’essence et connaître leur limite de consommation. Lorsqu’un client effectue une prise de carburant, il ne peut plus en reprendre avant un certain délai (ex : 24h), afin de garantir une distribution plus équitable.

Côté pompiste, la plateforme permet d’enregistrer les prises d’essence, gérer les stocks de carburant en temps réel, ajouter du stock après approvisionnement, consulter la carte des stations et effectuer des recherches par immatriculation. Le stock est automatiquement mis à jour après chaque prise enregistrée.

---

## 🛠️ Technologies utilisées

* **Framework** : Symfony
* **Langage** : PHP
* **Base de données** : SQL (Adminer)
* **Conteneurisation** : Docker
* **Gestion de version** : GitHub
* **Design UI/UX** : Figma

---

## ⚙️ Installation

### 1. Cloner le projet

Cloner le dépôt Git via HTTPS ou SSH :

```bash
git clone https://github.com/Smarciano05/projetSmartFuel.git
```

ou

```bash
git clone git@github.com:Smarciano05/projetSmartFuel.git
```

---

### 2. Lancer les conteneurs Docker

```bash
 docker compose -f .docker/docker-compose.yaml  up -d
```

### 3. Installer les dépendances

```bash
docker exec -it smartfuel_php composer install
```

---

### 4. Lancer les migrations

```bash
docker exec smartfuel_php  php bin/console doctrine:migrations:migrate 
```

---

### 5. Importer les données

#### Import des stations :

```bash
docker exec smartfuel_php php bin/console app:import-station
```

#### Import des stocks de carburant :

La plateforme est actuellement limitée à la gestion de 20 stations-service.

```bash
docker exec smartfuel_php php bin/console app:import-stock-csv public/data/stockcarburant.csv
```

## 📦 Installation supplémentaire

### Bundle de vérification d’email

```bash
composer require symfonycasts/verify-email-bundle
```

---
## Installer les fixtures (si nécessaire) :

```bash
composer require --dev orm-fixtures
```

## Chargement des données sans suppression : 

```bash
 docker exec -it smartfuel_php  php bin/console doctrine:fixtures:load --append 
```

## 🧪 Comptes de test

### 👤 Client
- Email : sophie.dubois@test.com
- Mot de passe : Password  

### ⛽ Pompiste
- Email : marc.dupont@smartfuel.com  
- Mot de passe : Smartfuel
