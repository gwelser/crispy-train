<?php

namespace App\Models\Test;

use PHPUnit\Framework\TestCase;
use App\Models\Publisher;

class PublisherTest extends TestCase
{
    private Publisher $publisher;

    protected function setUp(): void
    {
        $this->publisher = new Publisher(
            id: 1,
            name: 'Marvel Comics',
            country: 'USA',
            establishedYear: 1939
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->publisher->getId());
    }

    public function testGetName(): void
    {
        $this->assertEquals('Marvel Comics', $this->publisher->getName());
    }

    public function testSetName(): void
    {
        $this->publisher->setName('DC Comics');
        $this->assertEquals('DC Comics', $this->publisher->getName());
    }

    public function testSetNameReturnsSelf(): void
    {
        $result = $this->publisher->setName('DC Comics');
        $this->assertSame($this->publisher, $result);
    }

    public function testGetCountry(): void
    {
        $this->assertEquals('USA', $this->publisher->getCountry());
    }

    public function testSetCountry(): void
    {
        $this->publisher->setCountry('Canada');
        $this->assertEquals('Canada', $this->publisher->getCountry());
    }

    public function testSetCountryReturnsSelf(): void
    {
        $result = $this->publisher->setCountry('Canada');
        $this->assertSame($this->publisher, $result);
    }

    public function testGetEstablishedYear(): void
    {
        $this->assertEquals(1939, $this->publisher->getEstablishedYear());
    }

    public function testSetEstablishedYear(): void
    {
        $this->publisher->setEstablishedYear(1940);
        $this->assertEquals(1940, $this->publisher->getEstablishedYear());
    }

    public function testSetEstablishedYearReturnsSelf(): void
    {
        $result = $this->publisher->setEstablishedYear(1940);
        $this->assertSame($this->publisher, $result);
    }
}
