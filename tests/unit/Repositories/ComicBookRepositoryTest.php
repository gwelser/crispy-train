<?php

namespace App\Repositories;

use App\Models\ComicBook;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class ComicBookRepositoryTest extends TestCase
{
    private PDO $pdo;
    private ComicBookRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->repository = new ComicBookRepository($this->pdo);
    }

    public function testFindById(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetch')
             ->willReturn([
                 'id' => 1,
                 'title' => 'Comic Book Title',
                 'issue_number' => 1,
                 'release_date' => '2024-01-01',
                 'publisher_id' => 2
             ]);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->once())
             ->method('bindParam')
             ->with(':id', 1, PDO::PARAM_INT);

        $stmt->expects($this->once())
             ->method('execute');

        $comicBook = $this->repository->findById(1);

        $this->assertInstanceOf(ComicBook::class, $comicBook);
        $this->assertEquals(1, $comicBook->getId());
        $this->assertEquals('Comic Book Title', $comicBook->getTitle());
    }

    public function testFindAll(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetchAll')
             ->willReturn([
                 [
                     'id' => 1,
                     'title' => 'Comic Book Title',
                     'issue_number' => 1,
                     'release_date' => '2024-01-01',
                     'publisher_id' => 2
                 ]
             ]);

        $this->pdo->expects($this->once())
                  ->method('query')
                  ->willReturn($stmt);

        $comicBooks = $this->repository->findAll();

        $this->assertIsArray($comicBooks);
        $this->assertInstanceOf(ComicBook::class, $comicBooks[0]);
        $this->assertEquals(1, $comicBooks[0]->getId());
    }

    public function testSave(): void
    {
        $comicBook = new ComicBook(
            id: 1,
            title: 'Comic Book Title',
            issueNumber: 1,
            releaseDate: new \DateTime('2024-01-01'),
            publisherId: 2
        );

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->exactly(4))
             ->method('bindValue')
             ->with($this->callback(function ($parameter) {
                 return in_array($parameter, [':title', ':issue_number', ':release_date', ':publisher_id']);
             }), $this->callback(function ($value) {
                 return is_string($value) || is_int($value);
             }));

        $result = $this->repository->save($comicBook);

        $this->assertTrue($result);
    }

    public function testUpdate(): void
    {
        $comicBook = new ComicBook(
            id: 1,
            title: 'Updated Title',
            issueNumber: 2,
            releaseDate: new \DateTime('2024-02-01'),
            publisherId: 3
        );

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->exactly(5))
             ->method('bindValue')
             ->with($this->callback(function ($parameter) {
                 return in_array($parameter, [':title', ':issue_number', ':release_date', ':publisher_id', ':id']);
             }), $this->callback(function ($value) {
                 return is_string($value) || is_int($value);
             }));

        $result = $this->repository->update($comicBook);

        $this->assertTrue($result);
    }

    public function testDelete(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->once())
             ->method('bindParam')
             ->with(':id', 1, PDO::PARAM_INT);

        $result = $this->repository->delete(1);

        $this->assertTrue($result);
    }
}
