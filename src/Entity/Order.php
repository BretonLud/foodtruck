<?php

namespace App\Entity;

use App\Entity\Traits\StripeTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{

    use StripeTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduits::class, mappedBy="command", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $orderProduits;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $checked = false;



    public function __construct()
    {
        $this->orderProduits = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|OrderProduits[]
     */
    public function getOrderProduits(): Collection
    {
        return $this->orderProduits;
    }

    public function addOrderProduit(OrderProduits $orderProduit): self
    {
        if (!$this->orderProduits->contains($orderProduit)) {
            $this->orderProduits[] = $orderProduit;
            $orderProduit->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderProduit(OrderProduits $orderProduit): self
    {
        if ($this->orderProduits->removeElement($orderProduit)) {
            // set the owning side to null (unless already changed)
            if ($orderProduit->getOrderId() === $this) {
                $orderProduit->setOrderId(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(?bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

}
