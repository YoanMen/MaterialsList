<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use App\Service\MaterialService;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[UniqueEntity('name', 'Un matériel avec ce nom existe déjà')]
#[ORM\HasLifecycleCallbacks]
class Material
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Groups(['material.show'])]
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 60,
        min: 3,
        maxMessage: 'Le nom ne doit pas dépasser 60 caractères',
        minMessage: 'Le nom doit faire minimum 3 caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['material.show'])]
    #[Assert\Regex(
        pattern: '/^[0-9]{1,7}(\.[0-9]{1,2})?$/',
        message: 'Le prix HT n\'est pas valide'
    )] private ?string $priceHT = null;
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['material.show'])]
    #[Assert\NotBlank()]
    #[Assert\Regex(
        pattern: '/^[0-9]{1,8}(\.[0-9]{1,2})?$/',
        message: 'Le prix TTC n\'est pas valide'
    )] private ?string $priceTTC = null;
    #[ORM\Column]
    #[Groups(['material.show'])]
    #[Assert\PositiveOrZero()]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(['material.show'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'materials')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['material.show'])]
    private ?TVA $tva = null;

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

    public function getPriceHT(): ?string
    {
        return $this->priceHT;
    }

    public function setPriceHT(string $priceHT): static
    {
        $this->priceHT = number_format(floatval($priceHT), 2, '.', '');

        return $this;
    }

    public function getPriceTTC(): ?string
    {
        return $this->priceTTC;
    }

    public function setPriceTTC(string $priceTTC): static
    {
        $this->priceTTC = number_format(floatval($priceTTC), 2, '.', '');

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format('d-m-Y');
    }

    public function getTVA(): ?TVA
    {
        return $this->tva;
    }

    public function setTVA(?TVA $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setTTC(): void
    {
        $tva = $this->getTVA();
        $price = MaterialService::calculateTTC($this->priceHT, $tva->getValue());
        $this->priceTTC = strval($price);
    }
}
