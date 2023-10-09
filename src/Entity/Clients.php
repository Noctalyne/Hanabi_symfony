<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsRepository::class)]
class Clients extends User
{

    /* PAS BESOIN D' ID CAR RECUPERER DE USER GRACE A EXTEND */
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(name:'id_client')]
    // private ?User $id;



    #[ORM\Column(length: 50, nullable: true, name: 'nom_client')]
    private ?string $nomClient = null;

    #[ORM\Column(length: 50, nullable: true, name: 'prenom_client')]
    private ?string $prenomClient = null;

    //Création colonne numéro télephone
    #[ORM\Column(length: 10, nullable: true, name: "num_telephone")]
    private ?string $telephone = null;



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




    /* A partir d'ici getter et setter des clés étrangère */

 
    // /**
    //  * @return Collection<int, Adresses>
    //  */

    // public function getAdresse(): Collection
    // {
    //     return $this->adresses;
    // }
}
