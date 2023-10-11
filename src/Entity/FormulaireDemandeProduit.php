<?php

namespace App\Entity;

use App\Repository\FormulaireDemandeProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulaireDemandeProduitRepository::class)]
class FormulaireDemandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $TypeProduit = null;

    #[ORM\Column(length: 300)]
    private ?string $descriptionProduit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // private ?\DateTimeInterface $dateEnvoieForm = null;
    private $dateEnvoieForm;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    // private ?\DateTimeInterface $dateReponseForm = null;
    private $dateReponseForm;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $reponseDemande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeProduit(): ?string
    {
        return $this->TypeProduit;
    }

    public function setTypeProduit(string $TypeProduit): static
    {
        $this->TypeProduit = $TypeProduit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->descriptionProduit;
    }

    public function setDescriptionProduit(string $descriptionProduit): static
    {
        $this->descriptionProduit = $descriptionProduit;

        return $this;
    }

    public function getDateEnvoieForm(): ?\DateTimeInterface
    {
        return $this->dateEnvoieForm;
    }

    public function setDateEnvoieForm(\DateTimeInterface $dateEnvoieForm): self
    {
        $this->dateEnvoieForm = $dateEnvoieForm;

        return $this;
    }

    public function getDateReponseForm(): ?\DateTimeInterface
    {
        return $this->dateReponseForm;
    }

    public function setDateReponseForm(?\DateTimeInterface $dateReponseForm): static
    {
        $this->dateReponseForm = $dateReponseForm;

        return $this;
    }

    public function getReponseDemande(): ?string 
    {
        return $this->reponseDemande;
    }

    public function setReponseDemande(?string $reponseDemande): static
    {
        $this->reponseDemande = $reponseDemande;

        return $this;
    }
}
