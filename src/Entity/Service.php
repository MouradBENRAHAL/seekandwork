<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var \DateTime
     *
     * @ORM\Column(name="rdv", type="date", nullable=false)
     */
    private $rdv;

    /**
     * @var string
     *
     * @ORM\Column(name="rapport", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="votre rapport est vide")
     */
    private $rapport;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="votre email est vide")
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRdv(): ?\DateTimeInterface
    {
        return $this->rdv;
    }

    public function setRdv(\DateTimeInterface $rdv): self
    {
        $this->rdv = $rdv;

        return $this;
    }

    public function getRapport()
    {
        return $this->rapport;
    }

    public function setRapport($rapport): self
    {
        $this->rapport = $rapport;

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


}
