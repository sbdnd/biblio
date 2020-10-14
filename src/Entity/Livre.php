<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert; 


/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 * @Vich\Uploadable
 */
class Livre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $resume;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank
     * @Assert\Isbn(
     *      type = "isbn13",
     *      message = "format isbn-13 requis"         
     * )
     */
    private $isbn;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Editeur::class, inversedBy="livres")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $editeur;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, inversedBy="livres", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $auteurs;

    /**
     * @ORM\OneToMany(targetEntity=Exemplaire::class, mappedBy="livre", orphanRemoval=true)
     */
    private $exemplaires;

    /**
     * Undocumented variable
     * @Vich\UploadableField(mapping="livre_image", fileNameProperty="imageName")
     * @Assert\Image(
     *          mimeTypes="image/jpeg",
     *          mimeTypesMessage="Format jpeg/jpg uniquement !!"
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime|null
     */
    private $updatedAt;


    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->exemplaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->titre);
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs[] = $auteur;
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        if ($this->auteurs->contains($auteur)) {
            $this->auteurs->removeElement($auteur);
        }

        return $this;
    }

    /**
     * @return Collection|Exemplaire[]
     */
    public function getExemplaires(): Collection
    {
        return $this->exemplaires;
    }

    public function addExemplaire(Exemplaire $exemplaire): self
    {
        if (!$this->exemplaires->contains($exemplaire)) {
            $this->exemplaires[] = $exemplaire;
            $exemplaire->setLivre($this);
        }

        return $this;
    }

    public function removeExemplaire(Exemplaire $exemplaire): self
    {
        if ($this->exemplaires->contains($exemplaire)) {
            $this->exemplaires->removeElement($exemplaire);
            // set the owning side to null (unless already changed)
            if ($exemplaire->getLivre() === $this) {
                $exemplaire->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    /**
     * @param null|string $imageName
     * @return self
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;
        return $this;
    }
    
    /**
     * @return File|null
     */ 
    public function getImageFile(): ?file
    {
        return $this->imageFile;
    }
    
    /**
     * @param File|null $imageFile  
     * @return self
     */ 
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
       
        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function __toString()
    {
        return $this->getTitre();
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}