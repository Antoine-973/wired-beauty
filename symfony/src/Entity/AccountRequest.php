<?php

namespace App\Entity;

use App\Repository\AccountRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRequestRepository::class)]
class AccountRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $first_name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $last_name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 10)]
    private ?string $phone;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $company;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $type;

    #[ORM\Column(type: 'text')]
    private $message;

    // #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    // private $_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    // public function getUser(): ?self
    // {
    //     return $this->_user;
    // }
    //
    // public function setUser(?self $_user): self
    // {
    //     $this->_user = $_user;
    //     return $this;
    // }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
