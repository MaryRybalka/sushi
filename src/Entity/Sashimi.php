<?php

namespace App\Entity;

use App\Repository\SashimiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SashimiRepository::class)
 */
class Sashimi
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
    private $fishType;

    /**
     * @ORM\Column(type="integer")
     */
    private $calories;

    public function __construct($id)
    {
        $this->id = $id;
    }
    
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

    public function getFishType(): ?string
    {
        return $this->fishType;
    }

    public function setFishType(string $fishType): self
    {
        $this->fishType = $fishType;

        return $this;
    }
}
