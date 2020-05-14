<?php

namespace App\Entity;

use App\Repository\AdherentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdherentRepository::class)
 */
class Adherent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomAdherent;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenomAdherent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailAdherent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $loginAdherent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdpAdherent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAdherent(): ?string
    {
        return $this->nomAdherent;
    }

    public function setNomAdherent(string $nomAdherent): self
    {
        $this->nomAdherent = $nomAdherent;

        return $this;
    }

    public function getPrenomAdherent(): ?string
    {
        return $this->prenomAdherent;
    }

    public function setPrenomAdherent(string $prenomAdherent): self
    {
        $this->prenomAdherent = $prenomAdherent;

        return $this;
    }

    public function getEmailAdherent(): ?string
    {
        return $this->emailAdherent;
    }

    public function setEmailAdherent(?string $emailAdherent): self
    {
        $this->emailAdherent = $emailAdherent;

        return $this;
    }

    public function getLoginAdherent(): ?string
    {
        return $this->loginAdherent;
    }

    public function setLoginAdherent(string $loginAdherent): self
    {
        $this->loginAdherent = $loginAdherent;

        return $this;
    }

    public function getMdpAdherent(): ?string
    {
        return $this->mdpAdherent;
    }

    public function setMdpAdherent(string $mdpAdherent): self
    {
        $this->mdpAdherent = $mdpAdherent;

        return $this;
    }
}
