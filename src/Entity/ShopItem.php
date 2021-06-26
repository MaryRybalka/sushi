<?php

namespace App\Entity;

use App\Repository\ShopItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopItemRepository::class)
 */
class ShopItem extends \App\Entity\CartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param mixed $typeId
     */
    public function setTypeId($typeId): void
    {
        $this->typeId = $typeId;
    }

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $typeId;

    /**
     * @ORM\ManyToOne(targetEntity=CartItem::class, inversedBy="ItemID")
     */
    private $CartList;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCartList(): ?CartItem
    {
        return $this->CartList;
    }

    public function setCartList(?CartItem $CartList): self
    {
        $this->CartList = $CartList;

        return $this;
    }
}
