<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(length: 255)]
    private ?string $adrLivraison = null;

    #[ORM\Column(length: 255)]
    private ?string $adrfacturation = null;

    #[ORM\Column(length: 255)]
    private ?string $transporteurSociete = null;

    #[ORM\Column]
    private ?float $Tprix = null;

    #[ORM\Column]
    private ?bool $isfinalized = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripId = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeLigne::class)]
    private Collection $commandeLignes;

    public function __construct()
    {
        $this->commandeLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getAdrLivraison(): ?string
    {
        return $this->adrLivraison;
    }

    public function setAdrLivraison(string $adrLivraison): static
    {
        $this->adrLivraison = $adrLivraison;

        return $this;
    }

    public function getAdrfacturation(): ?string
    {
        return $this->adrfacturation;
    }

    public function setAdrfacturation(string $adrfacturation): static
    {
        $this->adrfacturation = $adrfacturation;

        return $this;
    }

    public function getTransporteurSociete(): ?string
    {
        return $this->transporteurSociete;
    }

    public function setTransporteurSociete(string $transporteurSociete): static
    {
        $this->transporteurSociete = $transporteurSociete;

        return $this;
    }

    public function getTprix(): ?float
    {
        return $this->Tprix;
    }

    public function setTprix(float $Tprix): static
    {
        $this->Tprix = $Tprix;

        return $this;
    }

    public function isIsfinalized(): ?bool
    {
        return $this->isfinalized;
    }

    public function setIsfinalized(bool $isfinalized): static
    {
        $this->isfinalized = $isfinalized;

        return $this;
    }

    public function getStripId(): ?string
    {
        return $this->stripId;
    }

    public function setStripId(?string $stripId): static
    {
        $this->stripId = $stripId;

        return $this;
    }

    /**
     * @return Collection<int, CommandeLigne>
     */
    public function getCommandeLignes(): Collection
    {
        return $this->commandeLignes;
    }

    public function addCommandeLigne(CommandeLigne $commandeLigne): static
    {
        if (!$this->commandeLignes->contains($commandeLigne)) {
            $this->commandeLignes->add($commandeLigne);
            $commandeLigne->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeLigne(CommandeLigne $commandeLigne): static
    {
        if ($this->commandeLignes->removeElement($commandeLigne)) {
            // set the owning side to null (unless already changed)
            if ($commandeLigne->getCommande() === $this) {
                $commandeLigne->setCommande(null);
            }
        }

        return $this;
    }
}
