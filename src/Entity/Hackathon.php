<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Repository\HackathonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: HackathonRepository::class)]
#[API\ApiResource(
    operations: [
        new API\Get(normalizationContext: ['groups' => ['hackathon:read']]),
        new API\GetCollection(normalizationContext: ['groups' => ['hackathon:read']]),
        new API\Post(security: "is_granted('ROLE_ADMIN')", denormalizationContext: ['groups' => ['hackathon:write']]),
        new API\Patch(security: "is_granted('ROLE_ADMIN')", denormalizationContext: ['groups' => ['hackathon:write']]),
        new API\Delete(security: "is_granted('ROLE_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['hackathon:read']]
)]
class Hackathon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["hackathon:read", "hackathon:write"])]
    private ?\DateTime $dateHeureDebut = null;

    #[ORM\Column]
    #[Groups(["hackathon:read", "hackathon:write"])]
    private ?\DateTime $dateHeureFin = null;

    #[ORM\Column(length: 255)]
    #[Groups(["hackathon:read", "hackathon:write"])]
    private ?string $lieu = null;

    #[ORM\Column(length: 255)]
    #[Groups(["hackathon:read", "hackathon:write"])]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Groups(["hackathon:read", "hackathon:write"])]
    private ?string $theme = null;

    #[ORM\ManyToOne(inversedBy: 'hackathons')]
    #[Groups(["hackathon:read", "hackathon:write"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Organisateur $organisateur = null;

    /**
     * @var Collection<int, Projet>
     */
    #[ORM\OneToMany(targetEntity: Projet::class, mappedBy: 'hackathon')]
    private Collection $projets;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'hackathon')]
    private Collection $inscription;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->inscription = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTime
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTime $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTime
    {
        return $this->dateHeureFin;
    }

    public function setDateHeureFin(\DateTime $dateHeureFin): static
    {
        $this->dateHeureFin = $dateHeureFin;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    public function getOrganisateur(): ?Organisateur
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Organisateur $organisateur): static
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setHackathon($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getHackathon() === $this) {
                $projet->setHackathon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscription(): Collection
    {
        return $this->inscription;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription->add($inscription);
            $inscription->setHackathon($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscription->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getHackathon() === $this) {
                $inscription->setHackathon(null);
            }
        }

        return $this;
    }
}
