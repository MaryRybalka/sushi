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
     * @ORM\ManyToOne(targetEntity=CartItem::class, inversedBy="CartID")
     */
    private $ItemsList;


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

    public function getItemsList(): ?CartItem
    {
        return $this->ItemsList;
    }

    public function setItemsList(?CartItem $ItemsList): self
    {
        $this->ItemsList = $ItemsList;

        return $this;
    }

}
