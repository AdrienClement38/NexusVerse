<?php

namespace App\Entity;

use App\Repository\ImgRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImgRepository::class)]
class Img
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToMany(targetEntity: Player::class, mappedBy: 'images')]
    private Collection $players;

    #[ORM\ManyToMany(targetEntity: Champion::class, mappedBy: 'images')]
    private Collection $champions;

    #[ORM\ManyToMany(targetEntity: League::class, mappedBy: 'images')]
    private Collection $leagues;

    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'images')]
    private Collection $teams;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->champions = new ArrayCollection();
        $this->leagues = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
            $player->addImage($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            $player->removeImage($this);
        }

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
            $champion->addImage($this);
        }

        return $this;
    }

    public function removeChampion(Champion $champion): self
    {
        if ($this->champions->removeElement($champion)) {
            $champion->removeImage($this);
        }

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
            $league->addImage($this);
        }

        return $this;
    }

    public function removeLeague(League $league): self
    {
        if ($this->leagues->removeElement($league)) {
            $league->removeImage($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->addImage($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            $team->removeImage($this);
        }

        return $this;
    }
}
