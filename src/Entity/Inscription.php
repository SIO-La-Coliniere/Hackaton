<?php

namespace App\Entity;

use ApiPlatform\Metadata as API;
use App\Repository\InscriptionRepository;
use App\State\InscriptionCreateProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[API\ApiResource(
    operations: [
        new API\Get(normalizationContext: ['groups' => ['inscription:read']]),
        new API\GetCollection(security: "is_granted('ROLE_ADMIN')", normalizationContext: ['groups' => ['inscription:read']]),
        new API\Post(
            security: "is_granted('IS_AUTHENTICATED_FULLY')",
            processor: InscriptionCreateProcessor::class,
            denormalizationContext: ['groups' => ['inscription:write']]
        ),
        new API\Patch(security: "is_granted('ROLE_ADMIN')", denormalizationContext: ['groups' => ['inscription:write']]),
        new API\Delete(security: "is_granted('ROLE_ADMIN')"),
    ],
    normalizationContext: ['groups' => ['inscription:read']]
)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $num = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $competence = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participant $participant = null;

    #[ORM\ManyToOne(inversedBy: 'inscription')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hackathon $hackathon = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    private ?Equipe $regrouper = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Equipe $etreResponable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): static
    {
        $this->num = $num;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): static
    {
        $this->participant = $participant;

        return $this;
    }

    public function getHackathon(): ?Hackathon
    {
        return $this->hackathon;
    }

    public function setHackathon(?Hackathon $hackathon): static
    {
        $this->hackathon = $hackathon;

        return $this;
    }

    public function getRegrouper(): ?Equipe
    {
        return $this->regrouper;
    }

    public function setRegrouper(?Equipe $regrouper): static
    {
        $this->regrouper = $regrouper;

        return $this;
    }

    public function getEtreResponable(): ?Equipe
    {
        return $this->etreResponable;
    }

    public function setEtreResponable(?Equipe $etreResponable): static
    {
        $this->etreResponable = $etreResponable;

        return $this;
    }

}
