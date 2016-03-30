<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;

/**
 */
class MigrationsTestCase extends TestCase
{
    use DatabaseMigrations;

	public static function setUpBeforeClass()
	{
		file_put_contents('storage/database/testing.sqlite', '');
	}
}

