<?php

namespace App\DataFixtures;

use App\Entity\Adherent;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdherentFixture extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $adherent = new Adherent();
        $adherent
                ->setUsername('demo')
                ->setPassword($this->encoder->encodePassword($adherent, 'demo'))
                ->setNomAdherent('Mekkas')
                ->setPrenomAdherent('Samia')
                ->setEmailAdherent('samia.mekkas@gmail.com');
        $manager->persist($adherent);
        $manager->flush();
    }
}
