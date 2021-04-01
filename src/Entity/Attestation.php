<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Attestation
 *
 * @ORM\Table(name="attestation", indexes={@ORM\Index(name="fn_service", columns={"idservice"}), @ORM\Index(name="fn_identreprise", columns={"identreprise"})})
 * @ORM\Entity
 * @Vich\Uploadable
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
     * @ORM\Column(name="domaine", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $email;


    /**
     * @var \Service
     *
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idservice", referencedColumnName="id")
     * })
     */
    private $idservice;

    /**
     * @var \Entreprise
     *
     * @ORM\ManyToOne(targetEntity="Entreprise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="identreprise", referencedColumnName="id")
     * })
     */
    private $identreprise;
    // ... other fields

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="attestation_rapport", fileNameProperty="Filename")
     *
     * @var File|null
     */
    private $File;

    /**
     * @ORM\Column(name="Filename",type="string",length=255,nullable=false)
     *
     * @var string
     */
    private $Filename;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->File;
    }

    /**
     * @param File|null $File
     * @return Attestation
     */
    public function setFile(?File $File): Attestation
    {
        $this->File = $File;
        if ($this->File instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string
     *
     */
    public function getFilename(): string
    {
        return $this->Filename;
    }

    /**
     * @param string $Filename
     * @return Attestation
     */
    public function setFilename(?string $Filename): Attestation
    {
        $this->Filename = $Filename;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getIdentreprise(): ?Entreprise
    {
        return $this->identreprise;
    }

    public function setIdentreprise(?Entreprise $identreprise): self
    {
        $this->identreprise = $identreprise;

        return $this;
    }


}
