<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $listeArticles = [];

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $montantTotal = null;

    #[ORM\ManyToMany(targetEntity: Clients::class, inversedBy: 'commandes')]
    private Collection $idClient;

    public function __construct()
    {
        $this->idClient = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getListeArticles(): array
    {
        return $this->listeArticles;
    }

    public function setListeArticles(array $listeArticles): static
    {
        $this->listeArticles = $listeArticles;

        return $this;
    }

    public function getMontantTotal(): ?string
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(string $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    /**
     * @return Collection<int, Clients>
     */
    public function getIdClient(): Collection
    {
        return $this->idClient;
    }

    public function addIdClient(Clients $idClient): static
    {
        if (!$this->idClient->contains($idClient)) {
            $this->idClient->add($idClient);
        }

        return $this;
    }

    public function removeIdClient(Clients $idClient): static
    {
        $this->idClient->removeElement($idClient);

        return $this;
    }


}
