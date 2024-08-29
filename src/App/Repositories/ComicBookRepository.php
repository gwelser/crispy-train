<?php

namespace App\Repositories;

use App\Models\ComicBook;
use PDO;

class ComicBookRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Fetch a single comic book by its ID
    public function findById(int $id): ?ComicBook
    {
        $stmt = $this->db->prepare('SELECT * FROM comic_books WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->mapToComicBook($result) : null;
    }

    // Fetch all comic books
    public function findAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM comic_books');
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToComicBook'], $results);
    }

    // Save a new comic book
    public function save(ComicBook $comicBook): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO comic_books (title, issue_number, release_date, publisher_id) 
            VALUES (:title, :issue_number, :release_date, :publisher_id)'
        );

        $stmt->bindValue(':title', $comicBook->getTitle());
        $stmt->bindValue(':issue_number', $comicBook->getIssueNumber());
        $stmt->bindValue(':release_date', $comicBook->getReleaseDate()->format('Y-m-d'));
        $stmt->bindValue(':publisher_id', $comicBook->getPublisherId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update an existing comic book
    public function update(ComicBook $comicBook): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE comic_books SET 
            title = :title, 
            issue_number = :issue_number, 
            release_date = :release_date, 
            publisher_id = :publisher_id 
            WHERE id = :id'
        );

        $stmt->bindValue(':title', $comicBook->getTitle());
        $stmt->bindValue(':issue_number', $comicBook->getIssueNumber());
        $stmt->bindValue(':release_date', $comicBook->getReleaseDate()->format('Y-m-d'));
        $stmt->bindValue(':publisher_id', $comicBook->getPublisherId(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $comicBook->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete a comic book by its ID
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM comic_books WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Map database row to ComicBook object
    private function mapToComicBook(array $row): ComicBook
    {
        return new ComicBook(
            id: (int) $row['id'],
            title: $row['title'],
            issueNumber: (int) $row['issue_number'],
            releaseDate: new \DateTime($row['release_date']),
            publisherId: (int) $row['publisher_id']
        );
    }
}
