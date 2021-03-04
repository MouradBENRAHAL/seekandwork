<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reduction
 *
 * @ORM\Table(name="reduction", indexes={@ORM\Index(name="fn_formation", columns={"idformation"})})
 * @ORM\Entity
 */
class Reduction
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
     * @var float
     *
     * @ORM\Column(name="pourcentage", type="float", precision=10, scale=0, nullable=false)
     */
    private $pourcentage;

    /**
     * @var float
     *
     * @ORM\Column(name="calcul", type="float", precision=10, scale=0, nullable=false)
     */
    private $calcul;


    /**
     * @var \Formation
     *
     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idformation", referencedColumnName="id")
     * })
     */
    private $idformation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentage(): ?float
    {
        return $this->pourcentage;
    }

    public function setPourcentage(float $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getCalcul(): ?float
    {
        return $this->calcul;
    }

    public function setCalcul(float $calcul): self
    {
        $this->calcul = $calcul;

        return $this;
    }

    public function getIdformation(): ?Formation
    {
        return $this->idformation;
    }

    public function setIdformation(?Formation $idformation): self
    {
        $this->idformation = $idformation;

        return $this;
    }


}
