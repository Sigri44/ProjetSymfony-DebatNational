<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    //valeurs par défaut
    public function __construct()
    {
        $this->setDateCreated((new \DateTime()));
        $this->setClaps(0);
        $this->setIsPublished(true);
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez indiquer un contenu pour votre débat !")
     * @Assert\Length(min="15", max="5000", minMessage="15 caractères minimum svp !", maxMessage="5000 caractères minimum svp !")
     * @ORM\Column(type="text", length=5000)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $claps;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getClaps(): ?int
    {
        return $this->claps;
    }

    public function setClaps(int $claps): self
    {
        $this->claps = $claps;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->Question;
    }

    public function setQuestion(?Question $Question): self
    {
        $this->Question = $Question;

        return $this;
    }
}
