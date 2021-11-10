<?php

namespace App\Entity;

use App\Repository\SpentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpentRepository::class)
 */
class Spent
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
    private $expense_name;

    /**
     * @ORM\Column(type="float")
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="spents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenseName(): ?string
    {
        return $this->expense_name;
    }

    public function setExpenseName(string $expense_name): self
    {
        $this->expense_name = $expense_name;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): self
    {
        $this->cost = $cost;

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
}
