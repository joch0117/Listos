<?php

namespace App\Entity;

use App\Repository\BoardRepository;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: BoardRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['board:read']],
    denormalizationContext: ['groups' => ['board:write']],
    operations: [
        new Get(security: "object.getUser() == user"),
        new GetCollection(security: "is_granted('IS_AUTHENTICATED_FULLY')"),
        new Post(security: "is_granted('IS_AUTHENTICATED_FULLY')"),
        new Put(security: "object.getUser() == user"),
        new Patch(security: "object.getUser() == user"),
        new Delete(security: "object.getUser() == user"),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['user' => 'exact'])]
class Board
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['board:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['board:read', 'board:write'])]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'boards')]
    #[Groups(['board:read', 'board:write'])]
    private ?User $user = null;

    /**
     * @var Collection<int, TaskList>
     */
    #[ORM\OneToMany(targetEntity: TaskList::class, mappedBy: 'board')]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $taskLists;

    /**
     * @var Collection<int, Card>
     */
    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'board', orphanRemoval: true)]
    private Collection $cards;

    public function __construct()
    {
        $this->taskLists = new ArrayCollection();
        $this->cards = new ArrayCollection();
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
            $taskList->setBoard($this);
        }

        return $this;
    }

    public function removeTaskList(TaskList $taskList): static
    {
        if ($this->taskLists->removeElement($taskList)) {
            // set the owning side to null (unless already changed)
            if ($taskList->getBoard() === $this) {
                $taskList->setBoard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): static
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setBoard($this);
        }

        return $this;
    }

    public function removeCard(Card $card): static
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getBoard() === $this) {
                $card->setBoard(null);
            }
        }

        return $this;
    }
}
