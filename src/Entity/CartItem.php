<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Type;

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
     * @ORM\Column(type="integer")
     */
    private $CartID;

    /**
     * @ORM\Column(type="integer")
     */
    private $ItemID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setID(int $ID): self
    {
        $this->ID = $ID;

        return $this;
    }

    public function getCartID(): int
    {
        return $this->CartID;
    }

    public function getItemID(): int
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

    public function addCartID(ShopCart $cartID): self
    {
        if (!$this->CartID->contains($cartID)) {
            $this->CartID[] = $cartID;
            $cartID->addItemID($this);
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

}
