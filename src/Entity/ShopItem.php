<?php

namespace App\Entity;

use App\Entity\Gunkan;
use App\Entity\Sashimi;
use App\Repository\GunkanRepository;
use App\Repository\SashimiRepository;
use App\Repository\ShopItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopItemRepository::class)
 */
class ShopItem
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
     * @ORM\Column(type="integer", length=255)
     */
    private $typeId;

    /**
     * @ORM\ManyToMany(targetEntity=ShopCart::class, mappedBy="ItemList")
     */
    private $shopCarts;

    public function __construct()
    {
        $this->shopCarts = new ArrayCollection();
    }

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

    /**
     * @return Collection|ShopCart[]
     */
    public function getShopCarts(): Collection
    {
        return $this->shopCarts;
    }

    public function addShopCart(ShopCart $shopCart): self
    {
        if (!$this->shopCarts->contains($shopCart)) {
            $this->shopCarts[] = $shopCart;
            $shopCart->addItemList($this);
        }

        return $this;
    }

    public function removeShopCart(ShopCart $shopCart): self
    {
        if ($this->shopCarts->removeElement($shopCart)) {
            $shopCart->removeItemList($this);
        }

        return $this;
    }
//
//    public function getCalories(): int
//    {
//        $em = $this->getDoctrine()->getManager();
//        if ($this->type == "gunkan")
//            return $em->getRepository(Gunkan::class)->find(['id'=>$this->typeId]);
//        else
//            return $em->getRepository(Sashimi::class)->find(['id'=>$this->typeId]);
//    }
}
