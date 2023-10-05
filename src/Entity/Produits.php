<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_produit = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_produit = null;

    #[ORM\Column(length: 100)]
    private ?string $img_produit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $prix_produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom_Produit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNom_Produit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getDescription_Produit(): ?string
    {
        return $this->description_produit;
    }

    public function setDescription_Produit(?string $description_produit): static
    {
        $this->description_produit = $description_produit;

        return $this;
    }

    public function getImg_Produit(): ?string
    {
        return $this->img_produit;
    }

    public function setImg_Produit(string $img_produit): static
    {
        $this->img_produit = $img_produit;

        return $this;
    }

    public function getPrix_Produit(): ?string
    {
        return $this->prix_produit;
    }

    public function setPrix_Produit(string $prix_produit): static
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }
}
