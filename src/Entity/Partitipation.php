<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partitipation
 *
 * @ORM\Table(name="partitipation", indexes={@ORM\Index(name="fn_spec", columns={"idspecialisation"}), @ORM\Index(name="fn_userp", columns={"iduser"})})
 * @ORM\Entity
 */
class Partitipation
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var \Specialisation
     *
     * @ORM\ManyToOne(targetEntity="Specialisation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idspecialisation", referencedColumnName="id")
     * })
     */
    private $idspecialisation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getIdspecialisation(): ?Specialisation
    {
        return $this->idspecialisation;
    }

    public function setIdspecialisation(?Specialisation $idspecialisation): self
    {
        $this->idspecialisation = $idspecialisation;

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


}
