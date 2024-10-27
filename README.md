# Site de Gestion des Plannings

Ce site permet de gérer les plannings dans une formation, avec trois acteurs principaux : les étudiants, les enseignants, et l'administrateur.

## Présentation du Site

- **Les étudiants** : peuvent s’inscrire aux cours de leur formation et voir leur planning personnalisé.
- **Les enseignants** : sont responsables de certains cours et peuvent déplacer ou créer des séances dans le planning. Ils peuvent également voir leur planning personnalisé.
- **L’administrateur** : gère les tâches de création et modification des cours, des formations, des enseignants et des étudiants. Il a accès à toutes les fonctionnalités des étudiants et des enseignants, et peut voir le planning de tout le monde.

## Fonctionnalités

### Les étudiants :
- Voir la liste des cours de leur formation.
- Gestion des inscriptions :
  - Inscription et désinscription dans les cours.
  - Affichage de la liste des cours auxquels ils sont inscrits.
  - Rechercher un cours dans la liste des cours de la formation.
- Affichage du planning personnalisé :
  - Intégral.
  - Par cours.
  - Par semaine.

### Les enseignants :
- Voir la liste des cours dont ils sont responsables.
- Voir le planning personnalisé (les séances dont ils sont responsables) :
  - Intégral.
  - Par cours.
  - Par semaine.
- Gestion du planning :
  - Création, mise à jour et suppression des séances de cours.
  - Utilisation de deux vues différentes pour gérer le planning (par cours et par semaine).

### Pour les utilisateurs (étudiants ou enseignants) :
- Création de compte.
- Changement de mot de passe.
- Modification du nom/prénom.

### L’administrateur :
- **Gestion des utilisateurs** :
  - Afficher la liste de tous les utilisateurs, filtrer par type (étudiant/enseignant), rechercher par nom/prénom/login.
  - Accepter ou refuser un utilisateur auto-créé.
  - Associer un enseignant à un cours.
  - Création, modification (y compris le type) et suppression d’utilisateurs.
- **Gestion des cours** :
  - Liste et recherche par intitulé.
  - Création, modification, suppression de cours.
  - Association d’un enseignant à un cours.
  - Liste des cours par enseignant.
- **Gestion des formations** :
  - Liste, ajout, modification et suppression de formations.
- **Gestion du planning** :
  - Création, mise à jour et suppression de séances de cours (pour n’importe quel enseignant).
  - Utilisation de deux vues différentes pour les opérations (par cours et par semaine).

## Notes :

- Un seul endroit stocke les identifiants des acteurs (table `users`). Le type d’utilisateur est vérifié pour afficher les bonnes pages et droits.
- Un compte administrateur (`admin:admin`) est précréé dans la base initiale.
- Lorsqu’un utilisateur crée un compte, il doit indiquer sa formation. Ses informations sont stockées dans la table `users` avec un type `null`, indiquant qu’il est inactif jusqu'à validation par un administrateur.
- L’administrateur peut contourner la procédure en créant directement un enregistrement.
- Utilisez des Seeders pour remplir la base de données avec des données factices pour mieux tester le site.
- La base de données suit les conventions de nommage de Laravel (excepté pour la table des cours).

## Base de Données

- `users` : (id, nom, prenom, login, mdp, formation_id, type)
- `formations` : (id, intitule, created_at, updated_at)
- `cours` : (id, intitule, user_id, formation_id, created_at, updated_at)
- `cours_users` : (cours_id, user_id)
- `plannings` : (id, cours_id, date_debut, date_fin)

## Utilisation

1. **Clonez le dépôt :** `git clone https://github.com/nassimug/GestionCours`

2. **Naviguez dans le répertoire du projet :** `cd GestionCours`

3. **Installez les dépendances :** `composer install`

4. **Configuration de l'environnement :** - Copiez le fichier d'exemple d'environnement : `cp .env.example .env` - Générez la clé de l'application : `php artisan key:generate` - Mettez à jour le fichier `.env` avec les informations de votre base de données.

5. **Migration de la base de données :** `php artisan migrate`

6. **Lancez l'application :** `php artisan serve`

7. **Accédez à l'application :** - Ouvrez votre navigateur et allez à : [http://localhost:8000](http://localhost:8000)

