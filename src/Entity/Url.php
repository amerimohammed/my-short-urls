<?php

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrlRepository::class)]
class Url
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $longUrl = null;

    #[ORM\Column(length: 50)]
    private ?string $shortUrl = null;

    #[ORM\Column(nullable: true)]
    private ?int $visitedTimes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    public function setLongUrl(string $longUrl): static
    {
        $this->longUrl = $longUrl;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(string $shortUrl): static
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    public function getVisitedTimes(): ?int
    {
        return $this->visitedTimes;
    }

    public function setVisitedTimes(?int $visitedTimes): static
    {
        $this->visitedTimes = $visitedTimes;

        return $this;
    }
}
