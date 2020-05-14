<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $loginAdmin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdpAdmin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoginAdmin(): ?string
    {
        return $this->loginAdmin;
    }

    public function setLoginAdmin(string $loginAdmin): self
    {
        $this->loginAdmin = $loginAdmin;

        return $this;
    }

    public function getMdpAdmin(): ?string
    {
        return $this->mdpAdmin;
    }

    public function setMdpAdmin(string $mdpAdmin): self
    {
        $this->mdpAdmin = $mdpAdmin;

        return $this;
    }
}
