# backend

Ce dossier contient l'applicatif tounant sur le serveur web.

# API REST en PHP

Mise en place de l'API pour les tests en local avec WAMP. 
Dossier 'backend' placé  dans le dossier 'www' de WAMP.
Lien de l'API en local : localhost/backend

## Modèle Accounts

#### GET

Tous les comptes : 
```
api/accounts/ 
```
(en local : localhost/backend/accounts/)

Un compte : 
```
api/accounts/<id>
```
#### POST

Informations de login :
```
api/accounts/

form_data = {email : <email>, password : <password>}
```


Ajouter un compte
```
api/accounts/

form_data = {first_name : <prenom>, last_name : <nom>, email : <email>, phone_number : <numéro de téléphone>, password : <password>, type : <type>}
```


Ajouter un compte anonyme
```
api/accounts/

form_data = {first_name : <prenom>, last_name : <nom>, email : <email>, phone_number : <numéro de téléphone>}
```

## Modèle Offers

#### GET

Toutes les offres : 
```
api/offers/ 
```

Un offer : 
```
api/offers/<id>
```
#### POST

Modifier le status d'une offre:
```
api/offers/<id>

form_data = {status : <status>} 
```
status : 
 - 'validate' pour valider
 - 'archive' pour archiver (obsolete)
 - 'unarchive' pour désarchiver
 - 'remove' pour supprimer (refuser)



Ajouter une offre
```
api/offers/

form_data = {writer_id : <id de l'auteur>, content : <contenu>, type : <type>} 
```
