# Fichier de méthodologie

Avant tout commencement d'un projet, il faut réfléchir sur sa conception. 
Vous trouverez dans ce document toutes les étapes à suivre afin de bien réaliser ce projet. 
Puisque dans l'énoncé il est dit de : "mettre en application vos compétence techniques et méthodologiques", donc je crée un document pour la méthode. Afin de gagner du temps pour la suite du projet. 
https://docs.google.com/presentation/d/1ntvauZFXXF0Y8sLGNE0-KOxmjYy0VieY42Vo-GF5P_c/edit#slide=id.g40fb3df6c5_0_150

## 1ère étape 

Création de la bdd : https://github.com/e-guyot/tp_Partiels/blob/projet_method/bdd.sql

## 2e étape

Le docker à déjà été créé. 
Ne pas oublier de supprimer tous ces containers afin d'éviter les erreurs : ```docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)```
Lancer le docker : ```docker-compose up -d --build```
Lancer la bdd : ```docker-compose exec web php bin/console make:migration```
```docker-compose exec web php bin/console doctrine:migration:migrate```
- Créer un formulaire de login 
- Créer un user avec le role admin afin de pouvoir creer les autres utilisateur sans ligne de commande. Pour ouvrir la bdd on utilise la ligne de commande : ```docker-compose exec db mysql -u user -p``` pwd : pass

## 3e étape : créer en fonction du rôle à la connexion 

-- Si c'est un membre 
arrive sur la page de ces contenus, il peut modifier ou ajouter un contenu 
- télécharger le contenu : 
https://symfony.com/doc/4.0/controller/upload_file.html
- Le contenu est composé d'un markdown : https://twig.symfony.com/doc/2.x/filters/markdown_to_html.html
Le fichier a été créé il se trouve dans les templates. 
- un bouton accepte ou non par qui 
- voir les contenus publiés et par qui 
- enregistre sous format json les commentaires 

-- Si c'est un reviewer 
- voir tous les contenus, possibilité d'update le contenu 
- possibilité modif accept = TRUE pour approuvé 
- modifier json commentaires si veut laisser un commentaires
- même possibilité que le rôle membre, il peut en plus accept son contenu

-- Si c'est un communication 
- lien pour publier sur un réseau 
- Seulement les contenus approuvés sont affichés
- afficher les stats (métrics) https://blackfire.io/docs/reference-guide/metrics
// le compte communication reste ambiguë 

-- Si c'est Admin 

- Possèdent les droits comme les autres rôles 
En plus peut faire : 
- Créer et modifier les comptes leurs assigner des rôles 
- Configuration de la plateforme de réseaux Sociaux 
- A une vue sur la plateforme communication

J'ai eu beaucoup d'erreur avec docker et la création de la base d'où ce ficher de method afin d'expliquer ce que j'aurais fait si on aurait eu plus de temps. 
