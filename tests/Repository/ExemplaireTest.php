<?php

namespace App\tests\Repository;

use App\Repository\ExemplaireRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExemplaireTest extends KernelTestCase
{
    public function testExemplaireDispo()
    {
        self::bootKernel(); //démarrage du kernel pour récupérer un repository
        $disponibilty = self::$container->get(ExemplaireRepository::class)->findTotalExemplaireDispo(2);
        $this->assertEquals(1, $disponibilty);
    }
}