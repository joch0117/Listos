<?php

namespace App\Entity;

use App\Repository\DashboardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: DashboardRepository::class)]
#[ApiResource(security: "object == null or object.getUser() == user")]
#[ApiFilter(SearchFilter::class, properties: ['user' => 'exact'])]
class Dashboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $title = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'dashboard')]
    private Collection $user;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, TaskList>
     */
    #[ORM\OneToMany(targetEntity: TaskList::class, mappedBy: 'dashboard')]
    private Collection $taskLists;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->taskLists = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(?User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setDashboard($this);
        }
        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            if ($user->getDashboard() === $this) {
                $user->setDashboard(null);
            }
        }
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection<int, TaskList>
     */
    public function getTaskLists(): Collection
    {
        return $this->taskLists;
    }

    public function addTaskList(TaskList $taskList): static
    {
        if (!$this->taskLists->contains($taskList)) {
            $this->taskLists->add($taskList);
            $taskList->setDashboard($this);
        }
        return $this;
    }

    public function removeTaskList(TaskList $taskList): static
    {
        if ($this->taskLists->removeElement($taskList)) {
            if ($taskList->getDashboard() === $this) {
                $taskList->setDashboard(null);
            }
        }
        return $this;
    }
}

