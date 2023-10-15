<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

// Service
use App\Services\EventLogger\Base;

class EventLoggerServiceTest extends TestCase
{

    protected $serviceBaseClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceBaseClass = new Base();
    }

    public function test_calculation(): void
    {
        $result = $this->serviceBaseClass->calculate(5, 20);
        $this->assertEquals(25, $result);
    }
}