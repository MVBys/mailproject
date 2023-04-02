<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BaseTestClass extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    protected string $prefixUrl = '/api/';

    public function setUp(): void
    {
        parent::setUp();
    }
}
