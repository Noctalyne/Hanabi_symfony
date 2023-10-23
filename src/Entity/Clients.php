<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Repository\ClientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
# InheritanceType("JOINED")
#DiscriminatorColumn(name="discr", type="string")
#DiscriminatorMap({"user" = "User", "client" = "Client"})


#[ORM\Entity(repositoryClass: ClientsRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]

class Clients extends User /* */
{
    #[ORM\Column(length: 50, nullable: true, name: 'nomClient')]
    private ?string $nomClient = null;

    #[ORM\Column(length: 50, nullable: true, name: 'prenomClient')]
    private ?string $prenomClient = null;

    //Création colonne numéro télephone
    #[ORM\Column(length: 10, nullable: true, name: "telephone")]
    private ?string $telephone = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name: "user_id")]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'idClientPannier', cascade: ['persist', 'remove'])]
    private ?Panier $panier = null;

    #[ORM\ManyToMany(targetEntity: Commandes::class, mappedBy: 'idClientCommande', cascade: ['persist', 'remove'])]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'idClientAdresse', targetEntity: Adresses::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, name: 'adresse_client')]
    private Collection $adresses;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->adresses = new ArrayCollection();
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
    public function setTelephone(?string $telephone): self
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

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(Panier $panier): static
    {
        // set the owning side of the relation if necessary
        if ($panier->getIdClient() !== $this) {
            $panier->setIdClient($this);
        }

        $this->panier = $panier;

        return $this;
    }

    /**
     * @return Collection<int, Commandes>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addIdClient($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeIdClient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Adresses>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresses $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setIdClient($this);
        }

        return $this;
    }

    public function removeAdress(Adresses $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getIdClient() === $this) {
                $adress->setIdClient(null);
            }
        }

        return $this;
    }

}
