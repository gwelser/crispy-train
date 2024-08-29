<?php

namespace App\Repositories;

use App\Models\CreativeTeam;
use PDO;

class CreativeTeamRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Fetch a single creative team member by its ID
    public function findById(int $id): ?CreativeTeam
    {
        $stmt = $this->db->prepare('SELECT * FROM creative_team WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->mapToCreativeTeam($result) : null;
    }

    // Fetch all creative team members
    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM creative_team');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToCreativeTeam'], $results);
    }

    // Save a new creative team member
    public function save(CreativeTeam $creativeTeam): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO creative_team (name, role, comic_book_id) 
            VALUES (:name, :role, :comic_book_id)'
        );

        $stmt->bindValue(':name', $creativeTeam->getName());
        $stmt->bindValue(':role', $creativeTeam->getRole());
        $stmt->bindValue(':comic_book_id', $creativeTeam->getComicBookId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update an existing creative team member
    public function update(CreativeTeam $creativeTeam): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE creative_team SET 
            name = :name, 
            role = :role, 
            comic_book_id = :comic_book_id 
            WHERE id = :id'
        );

        $stmt->bindValue(':name', $creativeTeam->getName());
        $stmt->bindValue(':role', $creativeTeam->getRole());
        $stmt->bindValue(':comic_book_id', $creativeTeam->getComicBookId(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $creativeTeam->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete a creative team member by its ID
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM creative_team WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Map database row to CreativeTeam object
    private function mapToCreativeTeam(array $row): CreativeTeam
    {
        return new CreativeTeam(
            id: (int) $row['id'],
            name: $row['name'],
            role: $row['role'],
            comicBookId: (int) $row['comic_book_id']
        );
    }
}
