<?php

namespace App\Entity;

use App\Repository\ExemplaireRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $codeExemplaire;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateAcquisition;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="exemplaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $livre;

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
}
