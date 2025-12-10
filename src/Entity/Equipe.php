<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
#[API\ApiResource(
    operations: [
        new API\Get(normalizationContext: ['groups' => ['equipe:read']]),
        new API\GetCollection(normalizationContext: ['groups' => ['equipe:read']]),
        new API\Post(security: "is_granted('ROLE_ADMIN')", denormalizationContext: ['groups' => ['equipe:write']]),
        new API\Patch(security: "is_granted('ROLE_ADMIN')", denormalizationContext: ['groups' => ['equipe:write']]),
        new API\Delete(security: "is_granted('ROLE_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['equipe:read']]
)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $lienPrototype = null;

    #[ORM\ManyToOne(inversedBy: 'equipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projet = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'regrouper')]
    private Collection $inscriptions;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getLienPrototype(): ?string
    {
        return $this->lienPrototype;
    }

    public function setLienPrototype(string $lienPrototype): static
    {
        $this->lienPrototype = $lienPrototype;

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): static
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setRegrouper($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getRegrouper() === $this) {
                $inscription->setRegrouper(null);
            }
        }

        return $this;
    }
}
