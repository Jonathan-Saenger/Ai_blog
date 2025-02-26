<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir votre nom')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir votre email')]
    #[Assert\Email(message: 'Veuillez saisir un email valide')]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez saisir votre message')]
    #[Assert\Length(
        min: 10,
        minMessage: 'Votre message doit contenir au moins {{ limit }} caractères'
    )]
    private ?string $message = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez saisir un sujet')]
    #[Assert\Length(
        min: 5,
        max: 150,
        minMessage: 'Le sujet doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le sujet ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $subject = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }
}