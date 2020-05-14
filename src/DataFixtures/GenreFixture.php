<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GenreFixture extends Fixture
{
    /**
     * Insère dans la table GENRE une liste de catégorie de roman
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $names = ['littérature', 'aventure', 'horreur', 'nouvelle', 'science-fiction', 'BD', 'essai', 'policier', 'roman contemporain', 'poésie', 'théâtre', 'fantastique', 'romance'] ;
        
        foreach($names as $name)
        {
            $genre = new Genre();
            $genre->setLibelle($name);
            $manager->persist($genre);
        }
        $manager->flush();
    }
}
