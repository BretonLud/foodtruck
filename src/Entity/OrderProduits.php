<?php

namespace App\Entity;

use App\Repository\OrderProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Produits::class, mappedBy="orderProduits")
     */
    private $produits_id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderProduits")
     */
    private $order_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantité;

    public function __construct()
    {
        $this->produits_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Produits[]
     */
    public function getProduitsId(): Collection
    {
        return $this->produits_id;
    }

    public function addProduitsId(Produits $produitsId): self
    {
        if (!$this->produits_id->contains($produitsId)) {
            $this->produits_id[] = $produitsId;
            $produitsId->setOrderProduits($this);
        }

        return $this;
    }

    public function removeProduitsId(Produits $produitsId): self
    {
        if ($this->produits_id->removeElement($produitsId)) {
            // set the owning side to null (unless already changed)
            if ($produitsId->getOrderProduits() === $this) {
                $produitsId->setOrderProduits(null);
            }
        }

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(?Order $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }

    public function getQuantité(): ?int
    {
        return $this->quantité;
    }

    public function setQuantité(int $quantité): self
    {
        $this->quantité = $quantité;

        return $this;
    }
}
