<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: ClientsRepository::class)]
// #[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

class Clients extends User /* */
{

    /* VOIR SI BESOIN D' ID CAR RECUPERER DE USER GRACE A EXTEND */
    // #[ORM\Column(nullable: false, name: 'idClient')]
    // private ?int $idClient = null;

/**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
        *@ORM\OneToOne(targetEntity: "User", inversedBy: "client")
        *ORM\JoinColumn()
     */
    protected $user;


    public function getUser()
    {
        return $this->user;
    }
    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }


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


    public function getIdClient(): ?int
    {

        return $this->id;
    }

    public function setIdClient(?int $id): static
    {
        $this->id = $id;

        return $this;
    }


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

}
