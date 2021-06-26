<?php

namespace App\Entity;

use App\Repository\GunkanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GunkanRepository::class)
 */
class Gunkan
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
    private $quantityOfRice;

    /**
     * @ORM\Column(type="integer")
     */
    private $calories;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getQuantityOfRice(): ?int
    {
        return $this->quantityOfRice;
    }

    public function setEntityOfRice(int $quantityOfRice): self
    {
        $this->quantityOfRice = $quantityOfRice;

        return $this;
    }
}
