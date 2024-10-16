# XYZ

<img src="docs/screenshots/home.png" alt="Page d'accueil" />

[Captures d'écran](docs/screenshots.md)

## Démarrage rapide

Pour démarrer le projet, lancer les commandes suivantes :

```bash
# Récupération des sources
$ git clone https://github.com/wallerand/xyz.git

# Lancement de la stack
$ docker-compose -p "projet-xyz" up -d

# Attendre le lancement des services

# Tâches d'installation (composer.json:49)
$ docker exec -it xyz-app composer run-script install-app
```

Se rendre ensuite sur [http://localhost:8045/board/1](http://localhost:8045/board/1) pour démarrer le projet.

### URL d'accès

| Nom             | URL                                      | Description |
|-----------------|------------------------------------------|-------------|
| **Application** | [localhost](http://localhost:80/)        | —           |
| **PMA**         | [localhost:8080](http://localhost:8080/) | Interface de gestion de la base de données   |
| **Kanboard**    | [localhost:8045](http://localhost:8045/project/1) | Backlog du projet   |
| **Maildev**     | [localhost:8025](http://localhost:8025/) | Serveur SMTP et interface de test des emails |

## Tâches (backlog)

Les tâches de développement sont organisées sous la forme d'un backlog accessible à l'adresse [http://localhost:8045/board/1](http://localhost:8045/board/1).

Pour se connecter, utiliser les identifiants suivants : 
- **Identifiant**: `dev`
- **Mot de passe**: `password`

## Cheatsheet

### Commandes (CLI)

Pour lancer des commandes dans le conteneur de l'application, utiliser le préfix `docker exec -it xyz-app {command}`.

Exemples :
```bash
$ docker exec -it xyz-app composer --version
$ docker exec -it xyz-app php artisan about
$ docker exec -it xyz-app php artisan make:model Example -msfc --test
```

### Archivage

Pour générer une archive du projet, utiliser la commande suivante :
```bash
$ git archive -o xyz-latest.zip HEAD
```

## Données de test

Des comptes de démonstration sont générés lors du seeding :

| Utilisateur | Adresse e-mail    |  Mot de passe |
|-------------|-------------------|---------------|
| user0001    | user0001@example.com | `password` |
| user0002    | user0002@example.com | `password` |
| ...         | ...                  | ...        |
| user0015    | user0015@example.com | `password` |

Lors du seeding, des exemples de contributions Soundcloud sont utilisés. Ces exemples sont récupérés à partir du fichier [TrackSamples.php](database/Samples/TrackSamples.php).