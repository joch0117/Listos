<?php

namespace App\Entity;

use App\Repository\MapRepository;
use App\Enum\StateMapEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MapRepository::class)]
class Map
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'maps')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?TaskList $taskList = null;

    #[ORM\ManyToOne(inversedBy: 'maps')]
    #[Assert\NotNull]
    private ?User $user = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?bool $finished = null;

    #[ORM\Column(type: 'integer')]
    private ?int $priority = null;

    #[ORM\Column(type: 'string', enumType: StateMapEnum::class, length: 20)]
    #[Assert\NotNull]
    private ?StateMapEnum $stateMap = StateMapEnum::A_FAIRE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getTaskList(): ?TaskList
    {
        return $this->taskList;
    }

    public function setTaskList(?TaskList $taskList): static
    {
        $this->taskList = $taskList;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): static
    {
        $this->finished = $finished;
        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    public function getStateMap(): ?StateMapEnum
    {
        return $this->stateMap;
    }

    public function setStateMap(StateMapEnum $stateMap): static
    {
        $this->stateMap = $stateMap;
        return $this;
    }
}
