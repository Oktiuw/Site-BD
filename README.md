# Symfony contacts
## Auteur
Aurélien VINCENT
## Installation/Configuration 
A faire en début de séance :
cd /working/votre_login |
rm -Rf /working/votre_login/symfony-contacts |
git clone https://iut-info.univ-reims.fr/gitlab/votre_login/symfony-contacts |
cd symfony-contacts |
composer install 
## Scripts
"start": "Lance le seveur web",
"test:cs": "Effectue une vérification du code",
"fix:cs": "Corrige le code"
"test:code" : Lance les tests codeception
"tests" : Lance les tests en entier
"db" : "Lance la création de donnée factices"
test:codeception": " Tests avec bd factice"

## Base de données 
La base est composée d'une table nommée contact avec pour champ :
-id : int
-lastname : str
-firstname : str
-email : str 
-category_id : int
Et d'une table category:
-id : int
-name : str
