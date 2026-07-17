<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $heroSousTitre = null;

    #[ORM\Column(length: 255)]
    private ?string $heroImage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $introduction = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $technique = null;

    #[ORM\Column(length: 255)]
    private ?string $imageTechnique = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $resultats = null;

    #[ORM\Column(length: 255)]
    private ?string $imageResultats = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $heroDescription = null;

    /**
     * @var Collection<int, Bienfait>
     */
    #[ORM\OneToMany(targetEntity: Bienfait::class, mappedBy: 'prestation', orphanRemoval: true)]
    private Collection $bienfaits;

    public function __construct()
    {
        $this->bienfaits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getHeroSousTitre(): ?string
    {
        return $this->heroSousTitre;
    }

    public function setHeroSousTitre(string $heroSousTitre): static
    {
        $this->heroSousTitre = $heroSousTitre;

        return $this;
    }

    public function getHeroImage(): ?string
    {
        return $this->heroImage;
    }

    public function setHeroImage(string $heroImage): static
    {
        $this->heroImage = $heroImage;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): static
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getTechnique(): ?string
    {
        return $this->technique;
    }

    public function setTechnique(string $technique): static
    {
        $this->technique = $technique;

        return $this;
    }

    public function getImageTechnique(): ?string
    {
        return $this->imageTechnique;
    }

    public function setImageTechnique(string $imageTechnique): static
    {
        $this->imageTechnique = $imageTechnique;

        return $this;
    }

    public function getResultats(): ?string
    {
        return $this->resultats;
    }

    public function setResultats(string $resultats): static
    {
        $this->resultats = $resultats;

        return $this;
    }

    public function getImageResultats(): ?string
    {
        return $this->imageResultats;
    }

    public function setImageResultats(string $imageResultats): static
    {
        $this->imageResultats = $imageResultats;

        return $this;
    }

    public function getHeroDescription(): ?string
    {
        return $this->heroDescription;
    }

    public function setHeroDescription(string $heroDescription): static
    {
        $this->heroDescription = $heroDescription;

        return $this;
    }

    /**
     * @return Collection<int, Bienfait>
     */
    public function getBienfaits(): Collection
    {
        return $this->bienfaits;
    }

    public function addBienfait(Bienfait $bienfait): static
    {
        if (!$this->bienfaits->contains($bienfait)) {
            $this->bienfaits->add($bienfait);
            $bienfait->setPrestation($this);
        }

        return $this;
    }

    public function removeBienfait(Bienfait $bienfait): static
    {
        if ($this->bienfaits->removeElement($bienfait)) {
            // set the owning side to null (unless already changed)
            if ($bienfait->getPrestation() === $this) {
                $bienfait->setPrestation(null);
            }
        }

        return $this;
    }
    
    public function __toString(): string
{
    return $this->nom ?? '';
}
}
