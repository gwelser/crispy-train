<?php

namespace App\Models;

class ComicBook
{
    private int $id;
    private string $title;
    private int $issueNumber;
    private \DateTime $releaseDate;
    private int $publisherId;

    public function __construct(
        int $id,
        string $title,
        int $issueNumber,
        \DateTime $releaseDate,
        int $publisherId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->issueNumber = $issueNumber;
        $this->releaseDate = $releaseDate;
        $this->publisherId = $publisherId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getIssueNumber(): int
    {
        return $this->issueNumber;
    }

    public function setIssueNumber(int $issueNumber): static
    {
        $this->issueNumber = $issueNumber;
        return $this;
    }

    public function getReleaseDate(): \DateTime
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime $releaseDate): static
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getPublisherId(): int
    {
        return $this->publisherId;
    }

    public function setPublisherId(int $publisherId): static
    {
        $this->publisherId = $publisherId;
        return $this;
    }
}
