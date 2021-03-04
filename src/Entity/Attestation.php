<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Attestation
 *
 * @ORM\Table(name="attestation", indexes={@ORM\Index(name="fn_service", columns={"idservice"})})
 * @ORM\Entity
 */
class Attestation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="demande", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez remplir la demande")
     */
    private $demande;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez remplir le domaine")
     */
    private $domaine;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Service
     *
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idservice", referencedColumnName="id")
     * })
     */
    private $idservice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?string
    {
        return $this->demande;
    }

    public function setDemande(string $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdservice(): ?Service
    {
        return $this->idservice;
    }

    public function setIdservice(?Service $idservice): self
    {
        $this->idservice = $idservice;

        return $this;
    }


}
