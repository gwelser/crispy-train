<?php

namespace App\Repositories;

use App\Models\Publisher;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class PublisherRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PublisherRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);
        $this->repository = new PublisherRepository($this->pdo);
    }

    public function testFindById(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetch')
             ->willReturn([
                 'id' => 1,
                 'name' => 'Publisher Name',
                 'country' => 'Country',
                 'established_year' => 1990
             ]);

        $this->pdo->expects($this->once())
                  ->method('prepare')
                  ->willReturn($stmt);

        $stmt->expects($this->once())
             ->method('bindParam')
             ->with(':id', 1, PDO::PARAM_INT);

        $stmt->expects($this->once())
             ->method('execute');

        $publisher = $this->repository->findById(1);

        $this->assertInstanceOf(Publisher::class, $publisher);
        $this->assertEquals(1, $publisher->getId());
        $this->assertEquals('Publisher Name', $publisher->getName());
    }

    public function testFindAll(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())
             ->method('fetchAll')
             ->willReturn([
                 [
                     'id' => 1,
                     'name' => 'Publisher Name',
                     'country' => 'Country',
                     'established_year' => 1990
                 ]
             ]);

        $this->pdo->expects($this->once())
                  ->method('query')
                  ->willReturn($stmt);

        $publishers = $this->repository->findAll();

        $this->assertIsArray($publishers);
        $this->assertInstanceOf(Publisher::class, $publishers[0]);
        $this->assertEquals(1, $publishers[0]->getId());
    }

    public function testSave(): void
    {
        $publisher = new Publisher(
            id: 1,
            name: 'Publisher Name',
            country: 'Country',
            establishedYear: 1990
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
                 return in_array($parameter, [':name', ':country', ':established_year']);
             }), $this->callback(function ($value) {
                 return is_string($value) || is_int($value);
             }));

        $result = $this->repository->save($publisher);

        $this->assertTrue($result);
    }

    public function testUpdate(): void
    {
        $publisher = new Publisher(
            id: 1,
            name: 'Updated Publisher',
            country: 'Updated Country',
            establishedYear: 2000
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
                 return in_array($parameter, [':name', ':country', ':established_year', ':id']);
             }), $this->callback(function ($value) {
                 return is_string($value) || is_int($value);
             }));

        $result = $this->repository->update($publisher);

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
