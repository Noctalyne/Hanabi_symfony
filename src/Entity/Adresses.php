<?php

namespace App\Entity;

use App\Repository\AdressesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressesRepository::class)]
class Adresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Clé étrangère
    // #[ORM\ManyToOne]
    // #[ORM\JoinColumn(nullable: false, name: 'id_client')]
    // private ?clients $id_client = null;

    #[ORM\Column(name: 'num_adresse')]
    private ?int $numAdresse = null;

    #[ORM\Column(length: 50, name: 'rue_adresse')]
    private ?string $rueAdresse = null;

    #[ORM\Column(length: 50, name: 'complement_adresse')]
    private ?string $complementAdresse = null;

    #[ORM\Column(length: 30, name: 'ville_adresse')]
    private ?string $villeAdresse = null;

    #[ORM\Column(length: 10, name: 'cp_adresse')]
    private ?string $codePostpAdressse = null;

    #[ORM\Column(length: 30, name: 'pays_adresse')]
    private ?string $paysAdresse = null;

    #[ORM\ManyToOne(inversedBy: 'adresses', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name: 'id_client')]
    private ?Clients $idClient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getIdClient(): ?clients
    // {
    //     return $this->id_client;
    // }

    // public function setIdClient(?clients $id_client): static
    // {
    //     $this->id_client = $id_client;

    //     return $this;
    // }

    public function getNumAdresse(): ?int
    {
        return $this->numAdresse;
    }

    public function setNumAdresse(int $numAdresse): static
    {
        $this->numAdresse = $numAdresse;

        return $this;
    }

    public function getRueAdresse(): ?string
    {
        return $this->rueAdresse;
    }

    public function setRueAdresse(string $rueAdresse): static
    {
        $this->rueAdresse = $rueAdresse;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complementAdresse;
    }

    public function setComplementAdresse(string $complementAdresse): static
    {
        $this->complementAdresse = $complementAdresse;

        return $this;
    }

    public function getVilleAdresse(): ?string
    {
        return $this->villeAdresse;
    }

    public function setVilleAdresse(string $villeAdresse): static
    {
        $this->villeAdresse = $villeAdresse;

        return $this;
    }

    public function getCodePostpAdressse(): ?string
    {
        return $this->codePostpAdressse;
    }

    public function setCodePostpAdressse(string $codePostpAdressse): static
    {
        $this->codePostpAdressse = $codePostpAdressse;

        return $this;
    }

    public function getPaysAdresse(): ?string
    {
        return $this->paysAdresse;
    }

    public function setPaysAdresse(string $paysAdresse): static
    {
        $this->paysAdresse = $paysAdresse;

        return $this;
    }

    public function getIdClient(): ?Clients
    {
        return $this->idClient;
    }

    public function setIdClient(?Clients $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }
}
