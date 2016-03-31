<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TransactionsTestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLandingPage()
    {
        $this->visit('/')
             ->see('A tool to monitor your time')
			 ->see('Time-spotter')
			 ;
    }
	
	/**
     * Test Landing Page.
     *
     * @return void
     */
    public function testLandingPageWithUserLogged()
    {
        $user = factory(App\Models\User::class)->create();
        $this->actingAs($user)
            ->visit('/')
            ->see('A tool to monitor your time')
			->see('Time-spotter')
            ->see($user->name);
    }
}
