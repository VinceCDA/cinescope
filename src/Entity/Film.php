<?php

namespace App\Entity;

use App\Repository\FilmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmRepository::class)]
class Film
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $synopsis = null;

    #[ORM\Column(nullable: true)]
    private ?int $dateSortie = null;

    /**
     * @var Collection<int, Plateforme>
     */
    #[ORM\ManyToMany(targetEntity: Plateforme::class, inversedBy: 'films')]
    private Collection $plateformes;

    public function __construct()
    {
        $this->plateformes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getDateSortie(): ?int
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?int $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * @return Collection<int, Plateforme>
     */
    public function getPlateformes(): Collection
    {
        return $this->plateformes;
    }

    public function addPlateforme(Plateforme $plateforme): static
    {
        if (!$this->plateformes->contains($plateforme)) {
            $this->plateformes->add($plateforme);
        }

        return $this;
    }

    public function removePlateforme(Plateforme $plateforme): static
    {
        $this->plateformes->removeElement($plateforme);

        return $this;
    }
}
