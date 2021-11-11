# La bourse aux équipiers

La bourse aux équipiers a pour objectif de mettre en relation les équipiers souhaitant embarquer avec les skippers proposant des embarquements.

Les équipiers et les skippers doivent pouvoir déposer des offres qui, après validation par un modérateur, sont visibles par l'ensemble des visiteurs du sites (utilisateur anonymes et utilisateur authentifiés).

De manière à ne pas encombrer le site, les annonces trop anciennes peuvent être marquées obsolètes par le modérateur et ne plus être visibles lors de la consulation.

## Publier une annonce

### Rédiger l'annonce

Pour publier une annonce l'utilisateur _doit_ renseigner les informations suivantes :

* prénom
* nom
* email
* contenu : le texte de l'annonce
* type : demande d'embarquement (pour les équipiers) ou offre d'embarquement (pour les skippers)

Les champs du formulaire présentés à l'utilisateur _doivent_ être typés pour faciliter l'autocomplétion proposée par les navigateurs internet.

L'application _doit_ pré-remplir les champs prénom, nom et email quand l'utilisateur est un utilisateur authentifié.

L'application _doit_ indiquer à l'utilisateur que les champs prénom, nom, email et type sont obligatoires et ne pas permettre de soumettre le formulaire si ceux-ci sont vide.

Au moment où l'utilisateur soumet sont annonce l'application _doit_ y adjoindre l'horodatage courant (c'est à dire la date et l'heure).

Au moment où l'utilisateur soumet sont annonce l'application _doit_ y adjoindre un identifiant unique.

### Vérifier l'email de l'utilisateur

Quand l'utilisateur n'est pas un utilisateur authentifé l'application doit envoyer un email de vérification à l'adresse email indiqué dans l'annonce et placer l'annonce dans la _zone des annonces non authentifiées_.

L'email de vérification _doit_ contenir un texte explicatif indiquant que celui-ci est émis par le module de la bourse au équipiers du G.C.I. suite à la dépose d'une annonce.

L'email de vérification _doit_ contenir les informations de l'annonce.

L'email de vérification _doit_ contenir un lien permettant de confirmer que l'annonce a bien été envoyé par le destinataire de l'email.

L'email de vérification _doit_ contenir un lien permettant de d'infirmer que l'annonce a bien été envoyé par le destinataire de l'email.

Quand l'utilisateur active le lien de confirmation l'application _doit_ lui indiquer que son annonce a bien été prise en compte et va être publiée prochainement après vérification par un modérateur.

Quand l'utilisateur active le lien de confirmation l'application _doit_ placer l'annonce dans la _zone des annonces à valider_ et envoyer un mail de notification à l'ensemble des utilisateurs ayant le rôle de _modérateur_.

Quand l'utilisateur active le lien de d'infirmation (c'est à dire qu'il déclare ne pas être à l'origine de l'annonce) l'application _doit_ lui indiquer que cette annonce va être supprimée et que son email ne sera pas conservée.

Quand l'utilisateur active le lien d'infirmation l'application _doit_ supprimer l'annonce.

### Valider les annonces

L'utilisateur disposant du rôle de _modérateur_ doit avoir accès à la liste des annonces présentes dans la _zone des annonces à valider_.

La liste _doit_ présenter les prénom, nom, email, type et horodatage de dépôt de l'annonce ainsi qu'un condensé du contenu.

L'utilisateur _doit_ pouvoir consulter le contenu complet de l'annonce.

La liste _doit_ être triée par défaut dans l'ordre chronologique (la moins récente en premier).

L'utilisateur _doit_ pouvoir changer l'ordre du tri (chronologique ou anti-chronologique).

L'utilisateur _doit_ pouvoir filtrer les annonces en fonction du type (toutes, seulement des demandes d'embarquement ou seulement les offres d'embarquement).

L'utilisateur _doit_ pouvoir accepter une ou plusieurs annonces en une seule opération.

Quand une annonce est acceptée l'application _doit_ la placer dans la _zone des annonce validées_.

Quand une annonce est acceptée l'application _doit_ envoyer un email à la personne ayant déposé l'annonce pour l'informer de la situation. L'email doit contenir l'ensemble des informations de l'annonce.

Quand une annonce est acceptée l'application _doit_ y adjoindre l'horodatage courant en tant que date de validation.

L'utilisateur _doit_ pouvoir refuser une ou plusieurs annonces en une seule opération.

Quand l'utilisateur refuse une ou plusieurs annonces l'utilisateur _doit_ pouvoir saisir un texte indiquant la motivation du refus.

Quand une annonce est refusée l'application _doit_ supprimer l'annonce.

Quand une annonce est refusée l'application _doit_ envoyer un email indiquant que l'annonce a été refusée par le modérateur avec éventuellement la motivation du refus. L'email doit contenir l'ensemble des informations de l'annonce.

## Consulter les annonces

Tout utilisateur doit avoir accès à la liste des annonces présentes dans la _zone des annonces validées_.

La liste _doit_ présenter les prénom, nom, email, type et horodatage de dépôt de l'annonce ainsi qu'un condensé du contenu.

L'utilisateur _doit_ pouvoir consulter le contenu complet de l'annonce.

La liste _doit_ être triée par défaut dans l'ordre chronologique (la moins récente en premier).

L'utilisateur _doit_ pouvoir changer l'ordre du tri (chronologique ou anti-chronologique).

L'utilisateur _doit_ pouvoir filtrer les annonces en fonction du type (toutes, seulement des demandes d'embarquement ou seulement les offres d'embarquement).

Quand l'utilisateur dispose du rôle de _modérateur_ l'application _doit_ lui permettre de transférer une des annonces dans la _zone des annonces obsolètes_.

Lorsqu'une annonce est déclarée obsolète l'application _doit_ y adjoindre l'horodatage courant en tant que date d'obsolecence.

Quand l'utilisateur dispose du rôle de _modérateur_ l'application intègre dans la liste des annonces celles présentes dans la _zone des annonces obsolètes_.

Quand l'utilisateur dispose du rôle de _modérateur_ il doit pouvoir filtrer les annonces en fonction de leur obsolecence (voir toutes les annonces, uniquement les annonces valides ou uniquement les annonces obsolète).

L'application _doit_ marquer visuellement la différence entre les annonces valides et les annonce obsolètes.