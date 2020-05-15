<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuteurFixture extends Fixture
{
    /**
     * Insère des auteurs dans la table AUTEUR
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {   

        $donnees = [
            ['nom' => 'Dostoeïvski', 'prenom' =>'Fédor', 'nationalite'=>'Russe'],
            ['nom' => 'Semprun', 'prenom' =>'Jorge', 'nationalite'=>'Espagnol'],
            ['nom' => 'Tolstoï', 'prenom' =>'Leon', 'nationalite'=>'Russe'],
            ['nom' => 'Steinbeck', 'prenom' =>'John', 'nationalite'=>'Américain'],
            ['nom' => 'Ferro', 'prenom' =>'Marc', 'nationalite'=>'Français'],
            ['nom' => 'Stocker', 'prenom' =>'Bram', 'nationalite'=>'Irlandais'],
            ['nom' => 'Shelley', 'prenom' =>'Marie', 'nationalite'=>'Britannique'],
            ['nom' => 'King', 'prenom' =>'Stephen', 'nationalite'=>'Américain'],
            ['nom' => 'Grass', 'prenom' =>'Gunter', 'nationalite'=>'Allemand'],
            ['nom' => 'Barjavel', 'prenom' =>'René', 'nationalite'=>'Français'],
        ];
        
        for ($i=0; $i<count($donnees); $i++)
        {
            $auteur = new Auteur();
            $auteur
                ->setNomAuteur($donnees[$i]['nom'])
                ->setPrenomAuteur($donnees[$i]['prenom'])
                ->setNationalite($donnees[$i]['nationalite']) ;
            $manager->persist($auteur);
        }
        
        $manager->flush();
    }
}
