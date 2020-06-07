<?php

namespace App\Entity;

use App\Repository\ExemplaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ExemplaireRepository::class)
 */
class Exemplaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $codeExemplaire;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAcquisition;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="exemplaires", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     * 
     */
    private $livre;

    /**
     * @ORM\OneToMany(targetEntity=Reserver::class, mappedBy="exemplaire", orphanRemoval=true)
     */
    private $reservations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dispo;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeExemplaire(): ?string
    {
        return $this->codeExemplaire;
    }

    public function setCodeExemplaire(string $codeExemplaire): self
    {
        $this->codeExemplaire = $codeExemplaire;

        return $this;
    }

    public function getDateAcquisition(): ?\DateTimeInterface
    {
        return $this->dateAcquisition;
    }

    public function setDateAcquisition(?\DateTimeInterface $dateAcquisition): self
    {
        $this->dateAcquisition = $dateAcquisition;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * @return Collection|Reserver[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addEmprunt(Reserver $reservation): self
    {
        if (!$this->emprunts->contains($reservation)) {
            $this->emprunts[] = $reservation;
            $reservation->setExemplaire($this);
        }

        return $this;
    }

    public function removeEmprunt(Reserver $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getExemplaire() === $this) {
                $reservation->setExemplaire(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getCodeExemplaire();
    }

    public function getDispo(): ?bool
    {
        return $this->dispo;
    }

    public function setDispo(bool $dispo): self
    {
        $this->dispo = $dispo;

        return $this;
    }
}