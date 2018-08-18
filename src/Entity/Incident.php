<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidentRepository")
 */
class Incident
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beaconId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $feeling;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $happening;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getBeaconId(): ?string
    {
        return $this->beaconId;
    }

    public function setBeaconId(string $beaconId): self
    {
        $this->beaconId = $beaconId;

        return $this;
    }

    public function getFeeling(): ?string
    {
        return $this->feeling;
    }

    public function setFeeling(string $feeling): self
    {
        $this->feeling = $feeling;

        return $this;
    }

    public function getHappening(): ?string
    {
        return $this->happening;
    }

    public function setHappening(string $happening): self
    {
        $this->happening = $happening;

        return $this;
    }
}
