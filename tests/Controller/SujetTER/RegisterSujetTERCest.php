<?php

namespace App\Tests\Controller\SujetTER;

use App\Entity\GroupeEtudiants;
use App\Factory\EnseignantFactory;
use App\Factory\EtudiantFactory;
use App\Factory\GroupeEtudiantsFactory;
use App\Factory\NiveauFactory;
use App\Factory\SujetTERFactory;
use App\Factory\UtilisateurFactory;
use App\Tests\Support\ControllerTester;

use Codeception\Util\HttpCode;

use function Zenstruck\Foundry\create;

class RegisterSujetTERCest
{
    public function Register(ControllerTester $I)
    {
        $user = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $etudiant = EtudiantFactory::createOne(['cdUtil' => $user]);

        $niveau = NiveauFactory::createOne(['libNiv' => 'M1']);

        $etudiant->addGroupeEtudiant(GroupeEtudiantsFactory::createOne(['nomGroupe'=>'TD1',
                                                                        'niveau'=>$niveau])->object());

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => $niveau,
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        $I->amLoggedInAs($user->object());
        $I->amOnPage('/sujetter/1/register');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des Sujets TER');
        $I->see('Votre sujet TER', 'h1');
    }

    public function EtudiantWithoutSameLevel(ControllerTester $I)
    {
        $niveau1 = NiveauFactory::createOne(['libNiv' => 'M1']);
        $niveau2 = NiveauFactory::createOne(['libNiv' => 'M2']);

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => $niveau1,
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        #test pour un utilisateur ayant un niveau different
        $user1 = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $etudiant1 = EtudiantFactory::createOne(['cdUtil' => $user1]);
        $etudiant1->addGroupeEtudiant((GroupeEtudiantsFactory::createOne(['nomGroupe'=>'TD1',
                                                                            'niveau'=>$niveau2]))->object());
        $I->amLoggedInAs($user1->object());
        $I->amOnPage('/sujetter/1/register');
        $I->seeResponseCodeIs(HttpCode::INTERNAL_SERVER_ERROR);
    }

    public function EtudiantWantRegisterAlreadyTakenSubject(ControllerTester $I)
    {
        $niveau1 = NiveauFactory::createOne(['libNiv' => 'M1']);

        $user1 = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $etudiant1 = EtudiantFactory::createOne(['cdUtil' => $user1]);
        $etudiant1->addGroupeEtudiant((GroupeEtudiantsFactory::createOne(['nomGroupe'=>'TD1',
            'niveau'=>$niveau1]))->object());

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => $niveau1,
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => $etudiant1
        ]);

        #test pour un etudiant voulant s'inscrire a un sujet deja pris par un autre
        $user2 = UtilisateurFactory::createOne(['roles' => ['ROLE_ETUDIANT']]);
        $etudiant2 = EtudiantFactory::createOne(['cdUtil' => $user2]);
        $etudiant2->addGroupeEtudiant((GroupeEtudiantsFactory::createOne(['nomGroupe'=>'TD1',
            'niveau'=>$niveau1]))->object());
        $I->amLoggedInAs($user2->object());
        $I->amOnPage('/sujetter/1/register');
        $I->seeResponseCodeIs(HttpCode::INTERNAL_SERVER_ERROR);
    }

    public function EtudiantOnly(ControllerTester $I)
    {
        $niveau1 = NiveauFactory::createOne(['libNiv' => 'M1']);

        SujetTERFactory::createOne([
            'titreTer' => 'Création de site web',
            'descTer' => 'Créer et concevoir un site dans son ensemble',
            'niveau' => $niveau1,
            'enseignant' => EnseignantFactory::createOne(['cdUtil' => UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']])]),
            'etudiant' => null
        ]);

        #acces refusé pour les Enseignants
        $userEns = UtilisateurFactory::createOne(['roles' => ['ROLE_ENSEIGNANT']]);
        $I->amLoggedInAs($userEns->object());
        $I->amOnPage('/sujetter/1/register');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);

        #acces refusé pour les Entreprises
        $userEnt = UtilisateurFactory::createOne(['roles' => ['ROLE_ENTREPRISE']]);
        $I->amLoggedInAs($userEnt->object());
        $I->amOnPage('/sujetter/1/register');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
