<?php

namespace Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
use Tests\Support\DatabaseSetup;

abstract class FeatureTestCase extends BaseTestCase
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

    /**
     * Given a CSS selector string, check if the elements matching the query
     * contain the values provided, in the order they are provided.
     */
    public function seeInOrder(string $selector, array $contents): self
    {
        $matches = $this->crawler->filter($selector);

        try {
            foreach ($matches as $index => $domElement) {
                $needle = $contents[$index];
                $this->assertContains($needle, trim($domElement->textContent));
            }
        } catch (\Throwable $e) {
            $this->fail("Failed asserting that the element at index $index contains the string \"$contents[$index]\".");
        }

        return $this;
    }
}
