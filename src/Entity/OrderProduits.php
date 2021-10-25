<?php

namespace App\Entity;

use App\Repository\OrderProduitsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderProduitsRepository::class)
 */
class OrderProduits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produits::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderProduits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduits(): ?Produits
    {
        return $this->produits;
    }

    public function setProduits(?Produits $produits): self
    {
        $this->produits = $produits;

        return $this;
    }

    public function getCommand(): ?Order
    {
        return $this->command;
    }

    public function setCommand(?Order $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
