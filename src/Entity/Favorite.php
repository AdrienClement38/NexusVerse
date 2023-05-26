<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'userFavorites')]
    private Collection $Teams;

    #[ORM\ManyToMany(targetEntity: League::class, inversedBy: 'userFavorites')]
    private Collection $leagues;

    #[ORM\ManyToMany(targetEntity: Player::class, inversedBy: 'userFavorites')]
    private Collection $players;

    #[ORM\OneToOne(inversedBy: 'favorite', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->Teams = new ArrayCollection();
        $this->leagues = new ArrayCollection();
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->Teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->Teams->contains($team)) {
            $this->Teams->add($team);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        $this->Teams->removeElement($team);

        return $this;
    }

    /**
     * @return Collection<int, League>
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): self
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues->add($league);
        }

        return $this;
    }

    public function removeLeague(League $league): self
    {
        $this->leagues->removeElement($league);

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        $this->players->removeElement($player);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    // Mes customs méthodes :

    public function hasTeam(Team $team): bool
    {
        return $this->Teams->contains($team);
    }
    public function hasLeague(League $league): bool
    {
        return $this->leagues->contains($league);
    }
}
