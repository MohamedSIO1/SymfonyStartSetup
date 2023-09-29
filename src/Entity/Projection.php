<?php

namespace App\Entity;

use App\Repository\ProjectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectionRepository::class)]
class Projection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'projections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $film = null;

    #[ORM\OneToMany(mappedBy: 'film', targetEntity: self::class)]
    private Collection $projections;

    public function __construct()
    {
        $this->projections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getFilm(): ?self
    {
        return $this->film;
    }

    public function setFilm(?self $film): static
    {
        $this->film = $film;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getProjections(): Collection
    {
        return $this->projections;
    }

    public function addProjection(self $projection): static
    {
        if (!$this->projections->contains($projection)) {
            $this->projections->add($projection);
            $projection->setFilm($this);
        }

        return $this;
    }

    public function removeProjection(self $projection): static
    {
        if ($this->projections->removeElement($projection)) {
            // set the owning side to null (unless already changed)
            if ($projection->getFilm() === $this) {
                $projection->setFilm(null);
            }
        }

        return $this;
    }
}
