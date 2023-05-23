<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?Post $post = null;

    #[ORM\ManyToMany(targetEntity: Champion::class, inversedBy: 'players')]
    private Collection $champions;

    #[ORM\ManyToMany(targetEntity: Favorite::class, mappedBy: 'players')]
    private Collection $userFavorites;

    #[ORM\ManyToMany(targetEntity: Img::class, inversedBy: 'players')]
    private Collection $images;

    public function __construct()
    {
        $this->champions = new ArrayCollection();
        $this->userFavorites = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Collection<int, Champion>
     */
    public function getChampions(): Collection
    {
        return $this->champions;
    }

    public function addChampion(Champion $champion): self
    {
        if (!$this->champions->contains($champion)) {
            $this->champions->add($champion);
        }

        return $this;
    }

    public function removeChampion(Champion $champion): self
    {
        $this->champions->removeElement($champion);

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getUserFavorites(): Collection
    {
        return $this->userFavorites;
    }

    public function addUserFavorite(Favorite $userFavorite): self
    {
        if (!$this->userFavorites->contains($userFavorite)) {
            $this->userFavorites->add($userFavorite);
            $userFavorite->addPlayer($this);
        }

        return $this;
    }

    public function removeUserFavorite(Favorite $userFavorite): self
    {
        if ($this->userFavorites->removeElement($userFavorite)) {
            $userFavorite->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Img>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Img $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(Img $image): self
    {
        $this->images->removeElement($image);

        return $this;
    }
}
