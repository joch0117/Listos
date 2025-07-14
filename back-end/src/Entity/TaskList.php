<?php

namespace App\Entity;

use App\Repository\TaskListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskListRepository::class)]
class TaskList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'taskLists')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'taskLists')]
    private ?Dashboard $dashboard = null;

    #[ORM\Column(nullable: true)]
    private ?int $priority = null;

    /**
     * @var Collection<int, Map>
     */
    #[ORM\OneToMany(targetEntity: Map::class, mappedBy: 'taskList', orphanRemoval: true)]
    private Collection $maps;

    public function __construct()
    {
        $this->maps = new ArrayCollection();
    }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getDashboard(): ?Dashboard
    {
        return $this->dashboard;
    }

    public function setDashboard(?Dashboard $dashboard): static
    {
        $this->dashboard = $dashboard;
        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return Collection<int, Map>
     */
    public function getMaps(): Collection
    {
        return $this->maps;
    }

    public function addMap(Map $map): static
    {
        if (!$this->maps->contains($map)) {
            $this->maps->add($map);
            $map->setTaskList($this);
        }
        return $this;
    }

    public function removeMap(Map $map): static
    {
        if ($this->maps->removeElement($map)) {
            if ($map->getTaskList() === $this) {
                $map->setTaskList(null);
            }
        }
        return $this;
    }
}
