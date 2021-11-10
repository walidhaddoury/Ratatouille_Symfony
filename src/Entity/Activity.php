<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
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
    private $activity_name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $activity_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_finish;

    /**
     * @ORM\Column(type="array")
     */
    private $members = [];

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="activities")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityName(): ?string
    {
        return $this->activity_name;
    }

    public function setActivityName(string $activity_name): self
    {
        $this->activity_name = $activity_name;

        return $this;
    }

    public function getActivityDate(): ?\DateTimeInterface
    {
        return $this->activity_date;
    }

    public function setActivityDate(\DateTimeInterface $activity_date): self
    {
        $this->activity_date = $activity_date;

        return $this;
    }

    public function getIsFinish(): ?bool
    {
        return $this->is_finish;
    }

    public function setIsFinish(bool $is_finish): self
    {
        $this->is_finish = $is_finish;

        return $this;
    }

    public function getMembers(): ?array
    {
        return $this->members;
    }

    public function setMembers(array $members): self
    {
        $this->members = $members;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
