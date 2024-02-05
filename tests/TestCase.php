<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;
    protected $admin;

    protected static $migrationRun = false;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->artisan('db:seed', ['--class' => 'GenresTableSeeder']);
        
        // Create test users
        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
    }
}
