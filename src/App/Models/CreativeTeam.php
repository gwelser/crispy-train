<?php

namespace App\Models;

class CreativeTeam
{
    private int $id;
    private string $name;
    private string $role;
    private int $comicBookId;

    public function __construct(
        int $id,
        string $name,
        string $role,
        int $comicBookId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
        $this->comicBookId = $comicBookId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getComicBookId(): int
    {
        return $this->comicBookId;
    }

    public function setComicBookId(int $comicBookId): static
    {
        $this->comicBookId = $comicBookId;
        return $this;
    }
}
