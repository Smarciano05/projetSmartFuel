#🚀 Projet SmartFuel

## 👥 Membres de l'équipe

    Mariam Sidiki Diawara :  
    Shirel Marciano : shirel.marciano05@gmail.com
    Sarah Marecar : marecarsarah@gmail.com

## 📌 Description du projet



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

```bash
docker exec smartfuel_php php bin/console app:import-stock-csv public/data/stockcarburant.csv
```

---

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
docker exec -it <container_php> php bin/console doctrine:fixtures:load --append
```

## 🧪 Comptes de test

### 👤 Client
- Email : sophie.dubois@test.com
- Mot de passe : Password  

### ⛽ Pompiste
- Email : marc.dupont@smartfuel.com  
- Mot de passe : Smartfuel
