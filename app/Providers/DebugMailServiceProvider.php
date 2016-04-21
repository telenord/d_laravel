<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Swift_Mailer;
use \Swift_Plugins_Logger;
use \Swift_Plugins_LoggerPlugin;

class DebugMailServiceProvider extends ServiceProvider implements Swift_Plugins_Logger
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		if(env('SWIFT_MAIL_LOG', false)) {
			$this->app->resolving('swift.mailer', function (Swift_Mailer $mailer, $app) {
				$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($this));
			}); 
		}
    }
	
	/**
     * Add a log entry.
     *
     * @param string $entry
     */
    public function add($entry)
    {
		\Log::info($entry);
    }

    /**
     * Not implemented.
     */
    public function clear()
    {
    }

    /**
     * Not implemented.
     */
    public function dump()
    {
    }
}
