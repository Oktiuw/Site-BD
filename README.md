<!-- Logo PROJET -->
<br />
<div align="center">
  <a href="https://github.com/github_username/repo_name">
    <img src="public/img/logo_urca.JPG" alt="Logo" width="412" height="80">
  </a>

<h3 align="center">Site Web Master IA</h3>

  <h4 align="center">
    Description du projet
  </h4>
<p>Ce projet a pour but d'intégrer au master IA de Reims une application web permettant la gestion des Stages/sujets TERs/Contact entre profs entreprises et élèves</p>
</div>


<!-- Sommaire -->
<details>
  <summary>Sommaire</summary>
  <ol>
    <li>
      <a href="#Apropos">A propos</a>
    </li>
    <li>
      <a href="#Installation">Installation</a>
      <ul>
        <li><a href="#Debut">Début</a></li>
        <li><a href="#Clonage">Clonage</a></li>
      </ul>
    </li>
    <li><a href="#Basededonnees">Base de données</a></li>
    <li><a href="#Tests">Test</a></li>
    <li><a href="#Auteurs">Auteurs</a></li>
  </ol>
</details>



<!-- A propos -->
<h2 id="Apropos"> A propos </h2>

Ce projet a été réalisé dans le cadre d'une SAE au BUT Informatique de REIMS par des étudiants en 2nd année de BUT Informatique, ici, tous spécialisés dans le parcours "data" (=données).

<h2 id="Installation"> Installation </h2>

Voici une liste d'instructions pour commencer à développer sur ce projet

<h3 id="Debut"> Début </h3>

* composer
* php
* symfony

<h3 id="Clonage"> Clonage </h3>

1. Clonage
   ```sh
   git clone https://iut-info.univ-reims.fr/gitlab/vinc0064/sae3-01
   ```
2. Installation des paquets composer
   ```sh
   composer install
   ```
3. Configuration de la base de données
   ```
   Copier-coller le .env en .env.local et définir votre base de donées
   Ensuite, lancer le script 'composer db'
   ```

   



<!-- Base de données -->
<h2 id="Basededonnees"> Base de données  </h2>
La base comporte plusieurs entités ainsi que des relations de type 1,n n,m
N'hésitez pas à regarder le schéma dans votre SGBD pour mieux comprendre
<h3>Comptes de bases</h3>
Tous les comptes ont pour mot de passe par défaut 'test'<br>
Liste des comptes par défaut (login)

* Etudiant
* Enseignant
* Entreprise
* EnseignantAdmin

<h2 id="Tests"> Test  </h2>
Pour les tests, l'application utilise Codeception et doctrine2

   ```sh
  composer test
   ```

<h2 id="Auteurs"> Auteurs  </h2>

* Fouad BELHIA
* Alix PAYRAUDREAU
* Harun SEZGIN
* Khadija SIALA
* Aurélien VINCENT

<h2>Production</h2>
ip : 10.31.11.92 (VPN du département requis) <br>
phpmyadmin : 10.31.11.92/phpmyadmin<br>
Compte:<br>
Pour obtenir un compte autre qu'entreprise contacter :<br>
<strong>aurelien.vincent@etudiant.univ-reims.fr</strong><br>
<hr>
M Jonquet :
Nous vous avons crée un compte avec comme login 'Jonquet' et comme mot de passe 'sae3-01' pour le serveur en production <br>
Ce compte est un compte admin, il vous permettra d'effectuer ajout/suppressions/modifications sur quasiment toutes les entités <br>
Nous pouvons aussi vous octroyer un compte sur phpmyadmin si vous le désirez.




