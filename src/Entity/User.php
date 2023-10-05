<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    // Création de la colonne id
    #[ORM\Column]
    private ?int $id = null;

    //Création de la colonne role
    #[ORM\Column(name: "user_role")] /* le name donne le nom de la colonne */
    private array $roles = [];

    // Création de la colonne email
    #[ORM\Column(length: 180, name: "user_email", unique: true)] /* le name donne le nom de la colonne */
    private ?string $email = null;
    
    // Création de la colonne identifiant
    #[ORM\Column(name: "username")] /* le name donne le nom de la colonne */
    private ?string $username = null;

    /**
     * @var string The hashed password
     */
    // Création de la colonne password(codé de base)
    #[ORM\Column(name: "user_password")] /* le name donne le nom de la colonne */
    private ?string $password = null;



    // Création de la colonne nom
    #[ORM\Column(length: 255, name: "user_nom", nullable: true)]
    private ?string $nom = null;

    // Création de la colonne prénom
    #[ORM\Column(length: 255, name: "user_prenom", nullable: true)]
    private ?string $prenom = null;

   // Création colonne numéro télephone
    #[ORM\Column(length:10, name: "user_telephone", nullable: true)]
    private ?string $telephone = null;


    /* PARTIE QUI VA S'OCCUPER DES INFOS ADRESSE */

    // Création colonne numéro d'adresse
    #[ORM\Column(length: 5, name: "user_num_adresse", nullable: true)]
    private ?string $num_adresse = null;

    // Création colonne rue de l adresse
    #[ORM\Column(length: 150, name: "user_rue_adresse", nullable: true)]
    private ?string $rue_adresse = null;

    // Création colonne complément d'adresse
    #[ORM\Column(length: 100, name: "user_complement_adresse", nullable: true)]
    private ?string $complement_adresse = null;    

    // Création colonne ville d'adresse
    #[ORM\Column(length: 50, name: "user_ville_adresse", nullable: true)]
    private ?string $ville_adresse = null;

   // Création colonne code postal adresse
    #[ORM\Column(length: 10, name: "user_postcode_adresse", nullable: true)]
    private ?string $postcode_adresse = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email; // ici l user s identifier avec email voir si possible de mettre email + username
        // return (string) $this->username;
    }



    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }




    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password; //password fait référence a ce qui est dans le ORM en haut
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }



    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }





    /**
     * @see UserInterface
    */

    // gère le nom d utilisateur
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }


    // gère le nom du client
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }


    // gère le prénom du client
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }


    /* PARTIE QUI VA S'OCCUPER DES INFOS ADRESSE */

    //  gère le numéro télephone
   public function getTelephone(): ?string
   {
       return $this->telephone;
   }
   public function setTelephone(string $telephone): static
   {
       $this->telephone = $telephone;

       return $this;
   }

   //  gère le numéro d'adresse
   public function getNum_Adresse(): ?string
   {
       return $this->num_adresse;
   }
   public function setNum_Adresse(string $num_adresse): static
   {
       $this->num_adresse = $num_adresse;

       return $this;
   }

   //  gère le rue de l adresse
   public function getRue_Adresse(): ?string
   {
       return $this->rue_adresse;
   }
   public function setRue_Adresse(string  $rue_adresse): static
   {
       $this->rue_adresse = $rue_adresse;

       return $this;
   }

   //  gère le complément d'adresse
   public function getComplement_Adresse(): ?string
   {
       return $this->complement_adresse;
   }
   public function setComplement_Adresse(string $complement_adresse): static
   {
       $this->complement_adresse = $complement_adresse  ;

       return $this;
   }

   //  gère le ville d'adresse
   public function getVille_Adresse(): ?string
   {
       return $this->ville_adresse;
   }
   public function setVille_Adresse(string $ville_adresse ): static
   {
       $this->ville_adresse = $ville_adresse ;

       return $this;
   }

  //  gère le code postal adresse
  public function getPostcode_Adresse (): ?string
  {
      return $this->postcode_adresse ;
  }
  public function setPostcode_Adresse(string $postcode_adresse): static
  {
      $this->postcode_adresse = $postcode_adresse;

      return $this;
  }

    
}