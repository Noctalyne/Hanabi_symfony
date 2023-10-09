<?php

// Attribut en protected pour y accéder dans la classe enfant Client


namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['userEmail'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]

    // Création de la colonne id
    #[ORM\Column]
    private ?int $id = null;

    //Création de la colonne role
    #[ORM\Column(name: "user_role")] /* le name donne le nom de la colonne */
    protected array $roles = [];

    // Création de la colonne email
    #[ORM\Column(length: 50, name: "userEmail", unique: true)] /* le name donne le nom de la colonne */
    protected ?string $email = null;
    
    // Création de la colonne identifiant
    #[ORM\Column(length: 50, name: "username")] /* le name donne le nom de la colonne */
    protected ?string $username = null;

    /**
     * @var string The hashed password
     */
    // Création de la colonne password(codé de base)
    #[ORM\Column(length: 60, name: "user_password")] /* le name donne le nom de la colonne */
    protected ?string $password = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserEmail(): ?string
    {
        return $this->email;
    }

    public function setUserEmail(string $email): static
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

    // Gère le nom d utilisateur
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

      
}