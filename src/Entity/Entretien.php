<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entretien
 *
 * @ORM\Table(name="entretien", indexes={@ORM\Index(name="fn_embauche", columns={"idembauche"}), @ORM\Index(name="fn_user", columns={"iduser"})})
 * @ORM\Entity(repositoryClass="App\Repository\EntretienRepository")
 */
class Entretien
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
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="CV", type="string", length=255, nullable=false)
     */
    private $cv;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="begin", type="datetime", nullable=false)
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=false)
     */
    private $end;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \Embauche
     *
     * @ORM\ManyToOne(targetEntity="Embauche")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idembauche", referencedColumnName="id")
     * })
     */
    private $idembauche;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBegin(): ?\DateTimeInterface
    {
        return $this->begin;
    }

    public function setBegin(\DateTimeInterface $begin): self
    {
        $this->begin = $begin;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdembauche(): ?Embauche
    {
        return $this->idembauche;
    }

    public function setIdembauche(?Embauche $idembauche): self
    {
        $this->idembauche = $idembauche;

        return $this;
    }


}
