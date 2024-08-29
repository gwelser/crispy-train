<?php

namespace App\Models\Test;

use PHPUnit\Framework\TestCase;
use App\Models\CreativeTeam;

class CreativeTeamTest extends TestCase
{
    private CreativeTeam $creativeTeam;

    protected function setUp(): void
    {
        $this->creativeTeam = new CreativeTeam(
            id: 1,
            name: 'Stan Lee',
            role: 'Writer',
            comicBookId: 1
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->creativeTeam->getId());
    }

    public function testGetName(): void
    {
        $this->assertEquals('Stan Lee', $this->creativeTeam->getName());
    }

    public function testSetName(): void
    {
        $this->creativeTeam->setName('Jack Kirby');
        $this->assertEquals('Jack Kirby', $this->creativeTeam->getName());
    }

    public function testSetNameReturnsSelf(): void
    {
        $result = $this->creativeTeam->setName('Jack Kirby');
        $this->assertSame($this->creativeTeam, $result);
    }

    public function testGetRole(): void
    {
        $this->assertEquals('Writer', $this->creativeTeam->getRole());
    }

    public function testSetRole(): void
    {
        $this->creativeTeam->setRole('Artist');
        $this->assertEquals('Artist', $this->creativeTeam->getRole());
    }

    public function testSetRoleReturnsSelf(): void
    {
        $result = $this->creativeTeam->setRole('Artist');
        $this->assertSame($this->creativeTeam, $result);
    }

    public function testGetComicBookId(): void
    {
        $this->assertEquals(1, $this->creativeTeam->getComicBookId());
    }

    public function testSetComicBookId(): void
    {
        $this->creativeTeam->setComicBookId(2);
        $this->assertEquals(2, $this->creativeTeam->getComicBookId());
    }

    public function testSetComicBookIdReturnsSelf(): void
    {
        $result = $this->creativeTeam->setComicBookId(2);
        $this->assertSame($this->creativeTeam, $result);
    }
}
