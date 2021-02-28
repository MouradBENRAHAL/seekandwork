<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="fn_pubforum", columns={"idpublication"})})
 * @ORM\Entity
 */
class Commentaire
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
     * @var int
     *
     * @ORM\Column(name="message", type="integer", nullable=false)
     */
    private $message;

    /**
     * @var \Forum
     *
     * @ORM\ManyToOne(targetEntity="Forum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idpublication", referencedColumnName="id")
     * })
     */
    private $idpublication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?int
    {
        return $this->message;
    }

    public function setMessage(int $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getIdpublication(): ?Forum
    {
        return $this->idpublication;
    }

    public function setIdpublication(?Forum $idpublication): self
    {
        $this->idpublication = $idpublication;

        return $this;
    }


}
