<?php

namespace App\Models;

class Publisher
{
    private int $id;
    private string $name;
    private string $country;
    private int $establishedYear;

    public function __construct(
        int $id,
        string $name,
        string $country,
        int $establishedYear
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->country = $country;
        $this->establishedYear = $establishedYear;
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

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function getEstablishedYear(): int
    {
        return $this->establishedYear;
    }

    public function setEstablishedYear(int $establishedYear): static
    {
        $this->establishedYear = $establishedYear;
        return $this;
    }
}
