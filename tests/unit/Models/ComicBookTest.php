<?php

namespace App\Models\Test;

use PHPUnit\Framework\TestCase;
use App\Models\ComicBook;

class ComicBookTest extends TestCase
{
    private ComicBook $comicBook;

    protected function setUp(): void
    {
        $this->comicBook = new ComicBook(
            id: 1,
            title: 'Amazing Spider-Man',
            issueNumber: 1,
            releaseDate: new \DateTime('1963-03-01'),
            publisherId: 1
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->comicBook->getId());
    }

    public function testGetTitle(): void
    {
        $this->assertEquals('Amazing Spider-Man', $this->comicBook->getTitle());
    }

    public function testSetTitle(): void
    {
        $this->comicBook->setTitle('Spider-Man: Blue');
        $this->assertEquals('Spider-Man: Blue', $this->comicBook->getTitle());
    }

    public function testSetTitleReturnsSelf(): void
    {
        $result = $this->comicBook->setTitle('Spider-Man: Blue');
        $this->assertSame($this->comicBook, $result);
    }

    public function testGetIssueNumber(): void
    {
        $this->assertEquals(1, $this->comicBook->getIssueNumber());
    }

    public function testSetIssueNumber(): void
    {
        $this->comicBook->setIssueNumber(2);
        $this->assertEquals(2, $this->comicBook->getIssueNumber());
    }

    public function testSetIssueNumberReturnsSelf(): void
    {
        $result = $this->comicBook->setIssueNumber(2);
        $this->assertSame($this->comicBook, $result);
    }

    public function testGetReleaseDate(): void
    {
        $expectedDate = new \DateTime('1963-03-01');
        $this->assertEquals($expectedDate, $this->comicBook->getReleaseDate());
    }

    public function testSetReleaseDate(): void
    {
        $newDate = new \DateTime('1964-07-01');
        $this->comicBook->setReleaseDate($newDate);
        $this->assertEquals($newDate, $this->comicBook->getReleaseDate());
    }

    public function testSetReleaseDateReturnsSelf(): void
    {
        $newDate = new \DateTime('1964-07-01');
        $result = $this->comicBook->setReleaseDate($newDate);
        $this->assertSame($this->comicBook, $result);
    }

    public function testGetPublisherId(): void
    {
        $this->assertEquals(1, $this->comicBook->getPublisherId());
    }

    public function testSetPublisherId(): void
    {
        $this->comicBook->setPublisherId(2);
        $this->assertEquals(2, $this->comicBook->getPublisherId());
    }

    public function testSetPublisherIdReturnsSelf(): void
    {
        $result = $this->comicBook->setPublisherId(2);
        $this->assertSame($this->comicBook, $result);
    }
}
