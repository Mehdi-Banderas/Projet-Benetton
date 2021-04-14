<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $jobStartDate;

    /**
     * @ORM\ManyToOne(targetEntity=Recruteur::class, inversedBy="jobs")
     */
    private $RecruteurId;

    /**
     * @ORM\ManyToMany(targetEntity=Candidat::class, mappedBy="candidature")
     */
    private $candidats;

    public function __construct()
    {
       $this->datePublished = new \DateTime();
       $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    public function setDatePublished(\DateTimeInterface $datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getJobStartDate(): ?\DateTimeInterface
    {
        return $this->jobStartDate;
    }

    public function setJobStartDate(\DateTimeInterface $jobStartDate): self
    {
        $this->jobStartDate = $jobStartDate;

        return $this;
    }

    public function getRecruteurId(): ?Recruteur
    {
        return $this->RecruteurId;
    }

    public function setRecruteurId(?Recruteur $RecruteurId): self
    {
        $this->RecruteurId = $RecruteurId;

        return $this;
    }

    public function formatedForView()
    {
        return[
            "name" => $this->getName(),
            "description" =>$this->getDescription(),
            "job-start-date" => $this->getJobStartDate(),
            "date-published"=>$this->getDatePublished(),
            "id" => $this->getId(),
        ];
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->addCandidature($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->removeElement($candidat)) {
            $candidat->removeCandidature($this);
        }

        return $this;
    }
}
