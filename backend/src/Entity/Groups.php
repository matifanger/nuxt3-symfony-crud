<?php

namespace App\Entity;

use App\Repository\GroupsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupsRepository::class)]
#[ORM\Table(name: '`groups`')]
class Groups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $products = [];

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

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): static
    {
        $this->products = $products;

        return $this;
    }
}
