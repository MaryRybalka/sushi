<?php

namespace App\Entity;

use App\Repository\ShopCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopCartRepository::class)
 */
class ShopCart
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
    private $sessionID;

    /**
     * @ORM\ManyToMany(targetEntity=ShopItem::class, inversedBy="shopCarts")
     */
    private $ItemList;

    public function __construct()
    {
        $this->ItemList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionID(): ?string
    {
        return $this->sessionID;
    }

    public function setSessionID(string $sessionID): self
    {
        $this->sessionID = $sessionID;

        return $this;
    }

    /**
     * @return Collection|ShopItem[]
     */
    public function getItemList(): Collection
    {
        return $this->ItemList;
    }

    public function addItemList(ShopItem $item): self
    {
        if (!$this->ItemList->contains($item)) {
            $this->ItemList->add($item);
        } else {
            $this->ItemList[] = $item;
        }

        return $this;
    }

    public function removeItemList(ShopItem $itemList): self
    {
        $this->ItemList->removeElement($itemList);

        return $this;
    }
}
