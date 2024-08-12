<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // disable Vite in tests to prevent anymore errors in GHub Actions
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
