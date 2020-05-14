<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Editeur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EditeurFixture extends Fixture
{
    /**
     * Insère dans la table EDITEUR une liste de nom 
     * Les noms sont générés à partir du bundle "FAKER"
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10 ; $i++)
        {
            $editeur = new Editeur();
            $editeur
                ->setNomEditeur($faker->company);
                $manager->persist($editeur);
        }
        $manager->flush();
    }
}
