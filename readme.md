# OBJECTIFS
Entité
1. Créer une entité User afin de créer des utilisateurs (firstName, lastName, Email, Password,
etc).
2. Créer une entité Company (name, siren, activityArea, Address, cp, city, country, etc).
# Fonctionnement
1. Créer trois utilisateurs, 1 Admin et 2 clients. Chaque client sera lié à une compagnie
différente (Etc : Danone, Mondelez).
2. Créer un crud permettant d’ajouter, éditer, supprimer un utilisateur. A la création d’un
utilisateur, permettre de lui associer un rôle (admin, etc) et si l’utilisateur est un client
l’associer à une compagnie.
3. Créer un crud permettant d’ajouter, éditer, supprimer une compagnie.
4. Permettre aux clients de faire des appels API afin de récupérer des infos sur la
compagnie qui est associée à eux :
- Le client 1 devra récupérer toutes les données à l’exception de l’id et du siren.
- Le client 2 ne récupérera que le nom et l’activityArea.
5. Permettre aux clients d’éditer les données de leur compagnie par appel API.
## Attention
1. Pas besoin de faire une jolie interface pour les crud, un twig basic est largement suffisant.
2. Pour la création de l’APi vous êtes libre d’utiliser la solution de votre choix.
3. Seul l’administrateur pourra se connecter à l’interface d’administration avec les crud.
4. Les clients devront être authentifiés afin de pouvoir faire les appels API.
5. Les clients ne pourront éditer par API que les champs qu’ils ont le droit de voir à la
récupération

<hr>

# Installation du projet

1. Extraire le dossier
2. Dans le dossier extrait, faire la commande ```composer install``` pour installer toutes les dépendances
3. ``` php bin/console lexik:jwt:generate-keypair ``` pour générer les clés SSL nécessaire pour la création des JWT
3. Configurer le .env avec la bonne url de la base de données pour se connecter
4. Importer la base de données avec le fichier présent à la racine du projet, cela créera la base de données ainsi que les tables avec puis importera les données (nom du fichier export_db_projet_easypicky.sql)

Il y a 3 utilisateurs : <br>
  a. Admin
    Mail: admin@mail.fr
    Mdp: MotdePasse
  
  b. Client 1 (accès à seulement name et activity area)
    Mail: john@mail.fr
    Mdp: La1t!
    
  c. Client 2 (accès à tous sauf siren et id)
    Mail: luigi@mail.fr
    Mdp: Past@!

5. En tant **qu'administrateur**, lancer le projet avec le binaire et la commande ```symfony serve``` sinon avec la commande ```php -S 127.0.0.1:8000 -t public```

Se connecter sur ``` http://localhost:8000/ ```

# Appels API
Requêtes cURL, les faire avec un terminal Shell pour éviter les erreurs

Pour pouvoir effectuer les appels API il faut générer un token JWT avec les logins
```
curl --location --request POST 'http://127.0.0.1:8000/api/login_check' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username":"luigi@mail.fr",
    "password":"Past@!"
}' 
```

Cela va générer le token que l'on utilisera pour pouvoir s'identifier lors des autres appels api

# Différents appels API
## GET 
Cela permet de récupérer les informations de leur compagnie

### Récupérer les collections de compagnies (il n'est possible de voir que la compagnie de l'utilisateur)
```
curl --location --request GET 'http://127.0.0.1:8000/api/companies' \
--header 'Authorization: Bearer token'
```

### Récupérer une seule compagnie (modifier le numéro de fin entre 1 et 2)
```
curl --location --request GET 'http://127.0.0.1:8000/api/companies/1' \
--header 'Authorization: Bearer token'
```

## PATCH

Modifier la compagnie qui est liée à un utilisateur en envoyant un json

```
curl --location --request PATCH 'http://127.0.0.1:8000/api/companies/1' \
--header 'Accept: application/ld+json' \
--header 'Content-Type: application/merge-patch+json' \
--header 'Authorization: Bearer token' \
--data-raw '{
    "name": "Nestle",
            "activityArea": "Lait",
            "adress": "Boulevard du blé",
            "cp": "06000",
            "city": "Nice",
            "country": "France",
            "siren": "111111111"
}'
```

# Problème rencontré

* Le projet a un souci au niveau du javascript, il s'éxecute mais le document chargé est vide. Pour la création d'un utilisateur, c'est censé pouvoir bloquer le select de la compagnie en fonction du role choisi. La fonction est là mais ça ne s'éxecute pas (je ne sais pas pourquoi).

* Si erreur comme ça lancer le terminal en tant qu'administrateur pour lancer le serveur php

```
Warning: SessionHandler::read(): open(C:\Program Files (x86)\XAMPP\tmp\sess_jta5kd75a6tc0ecg9q6g74o2ai, O_RDWR) failed: Permission denied (13)
```
