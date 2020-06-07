<?php

namespace App\Entity;

use App\Repository\EmprunterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReserverRepository::class)
 */
class Reserver
{

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Exemplaire::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exemplaire;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=20)
     */
    private $datePret;


    public function getExemplaire(): ?Exemplaire
    {
        return $this->exemplaire;
    }

    public function setExemplaire(?Exemplaire $exemplaire): self
    {
        $this->exemplaire = $exemplaire;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function getDatePret(): string
    {
        return $this->datePret;
    }

    public function setDatePret(string $datePret): self
    {
        $this->datePret = $datePret;

        return $this;
    }

}