<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Repository\ClientsRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: ClientsRepository::class)]
// #[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

class Clients extends User /* */
{
    #[ORM\Column(length: 50, nullable: true, name: 'nom_client')]
    private ?string $nomClient = null;

    #[ORM\Column(length: 50, nullable: true, name: 'prenom_client')]
    private ?string $prenomClient = null;

    //Création colonne numéro télephone
    #[ORM\Column(length: 10, nullable: true, name: "telephone")]
    private ?string $telephone = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // #[ORM\OneToMany(mappedBy: 'adresse', targetEntity: Adresses::class)]
    // #[ORM\Column(nullable: true, name: "adresse")]
    // private Collection $adresses;


    // public function __construct()
    // {
    //     $this->adresses =  new ArrayCollection();
    // }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(?string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(?string $prenomClient): static
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    // Gère le numéro de tel 
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
