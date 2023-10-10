<?php

namespace App\Entity;

use App\Repository\VendeursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendeursRepository::class)]
class Vendeurs extends User
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?user $id_user = null;

    // #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    // private ?user $email_user = null;

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // public function getIdUser(): ?user
    // {
    //     return $this->id_user;
    // }

    // public function setIdUser(user $id_user): static
    // {
    //     $this->id_user = $id_user;

    //     return $this;
    // }

    // public function getEmailUser(): ?user
    // {
    //     return $this->email_user;
    // }

    // public function setEmailUser(user $email_user): static
    // {
    //     $this->email_user = $email_user;

    //     return $this;
    // }
}
