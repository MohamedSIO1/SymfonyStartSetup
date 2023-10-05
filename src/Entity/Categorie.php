<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'la_categorie', targetEntity: Article::class)]
    private Collection $les_articles;

    public function __construct()
    {
        $this->les_articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString() {
        return $this->nom;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getLesArticles(): Collection
    {
        return $this->les_articles;
    }

    public function addLesArticle(Article $lesArticle): static
    {
        if (!$this->les_articles->contains($lesArticle)) {
            $this->les_articles->add($lesArticle);
            $lesArticle->setLaCategorie($this);
        }

        return $this;
    }

    public function removeLesArticle(Article $lesArticle): static
    {
        if ($this->les_articles->removeElement($lesArticle)) {
            // set the owning side to null (unless already changed)
            if ($lesArticle->getLaCategorie() === $this) {
                $lesArticle->setLaCategorie(null);
            }
        }

        return $this;
    }
}
