<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specialisation
 *
 * @ORM\Table(name="specialisation", indexes={@ORM\Index(name="fn_idpartiticip", columns={"idpartitipation"}), @ORM\Index(name="fn_idevent", columns={"idevent"})})
 * @ORM\Entity
 */
class Specialisation
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
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Partitipation
     *
     * @ORM\ManyToOne(targetEntity="Partitipation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpartitipation", referencedColumnName="id")
     * })
     */
    private $idpartitipation;

    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idevent", referencedColumnName="id")
     * })
     */
    private $idevent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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

    public function getIdpartitipation(): ?Partitipation
    {
        return $this->idpartitipation;
    }

    public function setIdpartitipation(?Partitipation $idpartitipation): self
    {
        $this->idpartitipation = $idpartitipation;

        return $this;
    }

    public function getIdevent(): ?Event
    {
        return $this->idevent;
    }

    public function setIdevent(?Event $idevent): self
    {
        $this->idevent = $idevent;

        return $this;
    }


}
