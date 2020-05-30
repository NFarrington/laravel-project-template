<?php

namespace Tests\Feature;

use Illuminate\Support\Carbon;
use Tests\TestCase;

class MaintenanceModeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withExceptionHandling();
    }

    protected function tearDown(): void
    {
        $this->artisan("up");
        parent::tearDown();
    }

    /** @test */
    public function returns_503_when_application_is_down()
    {
        $this->artisan("down");

        $response = $this->get('/');

        $response->assertStatus(503);
    }

    /** @test */
    public function displays_default_message()
    {
        $this->artisan("down");

        $response = $this->get('/');

        $response->assertSee("Down for maintenance.");
    }

    /** @test */
    public function displays_custom_message_when_set()
    {
        $this->artisan("down", ["--message" => "My test message."]);

        $response = $this->get('/');

        $response->assertSee("My test message.");
    }

    /** @test */
    public function displays_retry_time()
    {
        $downtimeStart = Carbon::create(2020, 1, 1, 0, 0, 0);
        Carbon::setTestNow($downtimeStart);
        $this->artisan("down", ["--retry" => "60"]);
        Carbon::setTestNow($downtimeStart->addSeconds(30));

        $response = $this->get('/');

        $response->assertSee("Please try again 30 seconds from now.");
    }

    /** @test */
    public function displays_default_retry_message_when_retry_time_is_in_the_past()
    {
        $downtimeStart = Carbon::create(2020, 1, 1, 0, 0, 0);
        Carbon::setTestNow($downtimeStart);
        $this->artisan("down", ["--retry" => "60"]);
        Carbon::setTestNow($downtimeStart->addMinutes(2));

        $response = $this->get('/');

        $response->assertSee("Please try again later.");
    }
}
