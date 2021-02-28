<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity
 */
class Service
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
     * @ORM\Column(name="rdv", type="string", length=255, nullable=false)
     */
    private $rdv;

    /**
     * @var string
     *
     * @ORM\Column(name="rapport", type="string", length=255, nullable=false)
     */
    private $rapport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRdv(): ?string
    {
        return $this->rdv;
    }

    public function setRdv(string $rdv): self
    {
        $this->rdv = $rdv;

        return $this;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(string $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }


}
