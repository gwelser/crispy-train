<?php

namespace App\Repositories;

use App\Models\Publisher;
use PDO;

class PublisherRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Fetch a single publisher by its ID
    public function findById(int $id): ?Publisher
    {
        $stmt = $this->db->prepare('SELECT * FROM publishers WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->mapToPublisher($result) : null;
    }

    // Fetch all publishers
    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM publishers');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToPublisher'], $results);
    }

    // Save a new publisher
    public function save(Publisher $publisher): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO publishers (name, country, established_year) 
            VALUES (:name, :country, :established_year)'
        );

        $stmt->bindValue(':name', $publisher->getName());
        $stmt->bindValue(':country', $publisher->getCountry());
        $stmt->bindValue(':established_year', $publisher->getEstablishedYear(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update an existing publisher
    public function update(Publisher $publisher): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE publishers SET 
            name = :name, 
            country = :country, 
            established_year = :established_year 
            WHERE id = :id'
        );

        $stmt->bindValue(':name', $publisher->getName());
        $stmt->bindValue(':country', $publisher->getCountry());
        $stmt->bindValue(':established_year', $publisher->getEstablishedYear(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $publisher->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete a publisher by its ID
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM publishers WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Map database row to Publisher object
    private function mapToPublisher(array $row): Publisher
    {
        return new Publisher(
            id: (int) $row['id'],
            name: $row['name'],
            country: $row['country'],
            establishedYear: (int) $row['established_year']
        );
    }
}
