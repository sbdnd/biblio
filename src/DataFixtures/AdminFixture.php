<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Création d'un admin en base de données
     * avec un mot de passe encodé
     *
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setUsername('biblio1');
        $admin->setPassword($this->encoder->encodePassword($admin, 'test'));
        $admin->setNomAdmin('Dunand');
        $admin->setPrenomAdmin('Jean');
        $manager->persist($admin);
        $manager->flush();
    }
}
