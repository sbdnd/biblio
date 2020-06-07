<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin implements UserInterface 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $nomAdmin;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $prenomAdmin;

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getNomAdmin(): ?string
    {
        return $this->nomAdmin;
    }

    public function setNomAdmin(string $nomAdmin): self
    {
        $this->nomAdmin = $nomAdmin;

        return $this;
    }

    public function getPrenomAdmin(): ?string
    {
        return $this->prenomAdmin;
    }

    public function setPrenomAdmin(string $prenomAdmin): self
    {
        $this->prenomAdmin = $prenomAdmin;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

   
}