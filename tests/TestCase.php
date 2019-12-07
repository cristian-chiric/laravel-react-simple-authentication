<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\DatabaseSetup;

abstract class TestCase extends BaseTestCase
{
    use DatabaseSetup,
        CreatesApplication;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = '';

    protected function setUp(): void
    {
        $this->baseUrl = env('APP_URL');
        parent::setUp();
        $this->setupDatabase();
    }
}
