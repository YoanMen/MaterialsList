<?php

namespace App\Entity;

use App\Repository\TVARepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TVARepository::class)]
#[UniqueEntity('label', 'Une TVA avec ce nom existe déjà')]
class TVA
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Groups(['material.show'])]
    #[Assert\Length(
        max: 60,
        min: 3,
        maxMessage: 'Le label ne doit pas dépasser 60 caractères',
        minMessage: 'Le label doit faire minimum 3 caractères'
    )]
    private ?string $label = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 3)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }
}
