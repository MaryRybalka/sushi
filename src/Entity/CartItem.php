<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartItemRepository::class)
 */
class CartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entityItem;

    /**
     * @ORM\OneToMany(targetEntity=ShopCart::class, mappedBy="ItemsList")
     */
    private $CartID;

    /**
     * @ORM\OneToMany(targetEntity=ShopItem::class, mappedBy="CartList")
     */
    private $ItemID;

    public function __construct()
    {
        $this->CartID = new ArrayCollection();
        $this->ItemID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $ID): self
    {
        $this->ID = $ID;

        return $this;
    }


    public function getEntityItem(): ?string
    {
        return $this->entityItem;
    }

    public function setEntityItem(string $entityItem): self
    {
        $this->entityItem = $entityItem;

        return $this;
    }

    /**
     * @return Collection|ShopCart[]
     */
    public function getCartID(): Collection
    {
        return $this->CartID;
    }

    public function addCartID(ShopCart $cartID): self
    {
        if (!$this->CartID->contains($cartID)) {
            $this->CartID[] = $cartID;
            $cartID->setItemsList($this);
        }

        return $this;
    }

    public function removeCartID(ShopCart $cartID): self
    {
        if ($this->CartID->removeElement($cartID)) {
            // set the owning side to null (unless already changed)
            if ($cartID->getItemsList() === $this) {
                $cartID->setItemsList(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShopItem[]
     */
    public function getItemID(): Collection
    {
        return $this->ItemID;
    }

    public function addItemID(ShopItem $itemID): self
    {
        if (!$this->ItemID->contains($itemID)) {
            $this->ItemID[] = $itemID;
            $itemID->setCartList($this);
        }

        return $this;
    }

    public function removeItemID(ShopItem $itemID): self
    {
        if ($this->ItemID->removeElement($itemID)) {
            // set the owning side to null (unless already changed)
            if ($itemID->getCartList() === $this) {
                $itemID->setCartList(null);
            }
        }

        return $this;
    }

}
