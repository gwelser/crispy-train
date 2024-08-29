<?php

namespace App\Repositories;

use App\Models\CreativeTeam;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class CreativeTeamRepositoryTest extends TestCase
{
    private PDO $pdo;
    private CreativeTeamRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->repository = new CreativeTeamRepository($this->pdo);
    }

    public function testFindById(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetch')
             ->willReturn([
                 'id' => 1,
                 'name' => 'John Doe',
                 'role' => 'Artist',
                 'comic_book_id' => 2
             ]);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->once())
             ->method('bindParam')
             ->with(':id', 1, PDO::PARAM_INT);

        $stmt->expects($this->once())
             ->method('execute');

        $creativeTeam = $this->repository->findById(1);

        $this->assertInstanceOf(CreativeTeam::class, $creativeTeam);
        $this->assertEquals(1, $creativeTeam->getId());
        $this->assertEquals('John Doe', $creativeTeam->getName());
    }

    public function testFindAll(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetchAll')
             ->willReturn([
                 [
                     'id' => 1,
                     'name' => 'John Doe',
                     'role' => 'Artist',
                     'comic_book_id' => 2
                 ]
             ]);

        $this->pdo->expects($this->once())
                  ->method('query')
                  ->willReturn($stmt);

        $creativeTeams = $this->repository->findAll();

        $this->assertIsArray($creativeTeams);
        $this->assertInstanceOf(CreativeTeam::class, $creativeTeams[0]);
        $this->assertEquals(1, $creativeTeams[0]->getId());
    }

    public function testSave(): void
    {
        $creativeTeam = new CreativeTeam(
            id: 1,
            name: 'John Doe',
            role: 'Artist',
            comicBookId: 2
        );

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->exactly(3))
             ->method('bindValue')
             ->with($this->callback(function ($parameter) {
                 return in_array($parameter, [':name', ':role', ':comic_book_id']);
             }), $this->callback(function ($value) {
                 return is_string($value) || is_int($value);
             }));

        $result = $this->repository->save($creativeTeam);

        $this->assertTrue($result);
    }

    public function testUpdate(): void
    {
        $creativeTeam = new CreativeTeam(
            id: 1,
            name: 'Jane Smith',
            role: 'Writer',
            comicBookId: 3
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
                 return in_array($parameter, [':name', ':role', ':comic_book_id', ':id']);
             }), $this->callback(function ($value) {
                 return is_string($value) || is_int($value);
             }));

        $result = $this->repository->update($creativeTeam);

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
