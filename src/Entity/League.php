<?php

namespace App\Entity;

use App\Repository\LeagueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeagueRepository::class)]
class League
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToOne(mappedBy: 'league', cascade: ['persist', 'remove'])]
    private ?Tournament $tournament = null;

    #[ORM\ManyToMany(targetEntity: Favorite::class, mappedBy: 'leagues')]
    private Collection $userFavorites;

    #[ORM\ManyToMany(targetEntity: Img::class, inversedBy: 'leagues')]
    private Collection $images;

    public function __construct()
    {
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(Tournament $tournament): self
    {
        // set the owning side of the relation if necessary
        if ($tournament->getLeague() !== $this) {
            $tournament->setLeague($this);
        }

        $this->tournament = $tournament;

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
            $userFavorite->addLeague($this);
        }

        return $this;
    }

    public function removeUserFavorite(Favorite $userFavorite): self
    {
        if ($this->userFavorites->removeElement($userFavorite)) {
            $userFavorite->removeLeague($this);
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
