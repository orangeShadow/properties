<?php namespace orangeShadow\properties;

use Illuminate\Support\ServiceProvider;

class PropertiesServiceProvider extends ServiceProvider
{


	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
    			realpath(__DIR__.'/database/migrations') => $this->app->databasePath().'/migrations',
    		]);
	}


	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind(
            'orangeShadow\properties\Property',
            'orangeShadow\properties\PropertyValue'
        );
	}

}
