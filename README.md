# Wired Beauty
#### *Wired Beauty invents and develops innovative connected solutions for a new beauty.*

<p align="center">
    <img src="https://github.com/Antoine-973/wired-beauty/blob/develop/symfony/public/images/wb-logo.svg?raw=true" alt="Wired Beauty"/>
</p>

## Description

Wired Beauty invents and develops innovative connected solutions for a new beauty.

Our Mission:
Help Consumers and Brands to understand Skin and Hair in real Time to Adapt the ideal Beauty Routine in B2C and drive innovation in B2B

## Technologies in use
- [Symfony 6.0](https://symfony.com/doc/current/index.html)
- [Php-8.0](https://www.php.net/manual-lookup.php?pattern=php+unit&scope=quickref)
- [React JS](https://fr.reactjs.org/docs/getting-started.html)
- [Bootstrap](https://getbootstrap.com/docs/5.1/getting-started/introduction/)
- [Docker](https://docs.docker.com/)
- [Git](https://git-scm.com/doc)

## Requirement for starting

### Required

- [Docker](https://docs.docker.com/engine/install/)
- [Docker-Compose](https://docs.docker.com/compose/install/)
- Git (With configured [SSH](https://docs.github.com/en/authentication/connecting-to-github-with-ssh) and [GPG](https://docs.github.com/en/authentication/managing-commit-signature-verification/generating-a-new-gpg-key) Keys for signed commits)
- Knowledge of [Git Flow](https://www.atlassian.com/fr/git/tutorials/comparing-workflows/gitflow-workflow#:~:text=git%2Dflow%20est%20un%20outil,ex%C3%A9cuter%20brew%20install%20git%2Dflow%20.)

## Getting started

#### Start Application
```bash
docker-compose build --pull --no-cache
docker-compose up -d
```

#### Front-end initialisation
```bash
docker-compose exec php npm install

//For one scss compilation :
docker-compose exec php npm run dev

OR

//For constent scss compilation :
docker-compose exec php npm run watch
```

#### Configuration
```text
# URL
http://127.0.0.1

# Env DB
DATABASE_URL="postgresql://postgres:password@db:5432/db?serverVersion=13&charset=utf8"

# Sync & Queued Message Handling
MESSENGER_TRANSPORT_DSN=doctrine://default

# MAIL SMTP
MAILER_DSN="smtp://smtp:25?verify_peer=0"
```

## Useful commands
```
# List all existing commands 
docker-compose exec php php bin/console
# Delete browser cache
docker-compose exec php php bin/console cache:clear
# Creating a blank file
docker-compose exec php php bin/console make:controller
docker-compose exec php php bin/console make:form
# Creation of a complete CRUD
docker-compose exec php php bin/console make:crud
```

## Database management

#### Entity creation commands
```
docker-compose exec php php bin/console make:entity
```
Document on relationships between entities
https://symfony.com/doc/current/doctrine/associations.html

#### Updating the database
```
# See the requests that will be played with force
docker-compose exec php php bin/console doctrine:schema:update --dump-sql
# Execute DB requests
docker-compose exec php php bin/console doctrine:schema:update --force
```

#### Création des dataFixtures

https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html

Utilisation avec FakerBundle : https://github.com/fzaninotto/Faker#seeding-the-generator

#### Commande pour exécuter les datasFixtures

```
docker-compose exec php php bin/console doctrine:fixtures:load
```

## Gestion des formulaires

https://symfony.com/doc/current/reference/forms/types.html

## Gestion de l'authentification

https://symfony.com/doc/current/components/security/authentication.html

#### Commande pour générer l'auth

```
docker-compose exec php php bin/console make:user
docker-compose exec php php bin/console doctrine:schema:update --force
docker-compose exec php php bin/console make:auth
// Puis aller dans votre le fichier "custom authenticator" pour choisir la route de redirection après connexion (ligne 54).
```

## Sécurité

#### Contrôle d'accèss par role
https://symfony.com/doc/current/security.html#securing-controllers-and-other-code

####Validation des formulaires avec les Assert
https://symfony.com/doc/current/validation.html

####Création de test d'accessibilité avec les voters
https://symfony.com/doc/current/security/voters.html

## Gestion des messages flash
https://symfony.com/doc/current/controller.html#flash-messages

## Bundle d'aide

#### Gedmo
https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html
https://github.com/doctrine-extensions/DoctrineExtensions/tree/main/doc

#### Vich Uploader
https://github.com/dustin10/VichUploaderBundle/blob/master/docs/generating_urls.md

## Contact

- Antoine SAUNIER (Chef de projet, Developpeur ESGI)
- Julian SALEIX (Developpeur ESGI)
- Mohammed Adel SENHADJI (Developpeur ESGI)
- Emma LE VAN (Designeuse ICAN)
- Valentin BRICOUT (Marketeur ECITV)