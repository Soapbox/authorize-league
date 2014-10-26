<?php namespace SoapBox\AuthorizeLeague;

use Illuminate\Support\ServiceProvider;
use SoapBox\Authorize\StrategyFactory;

class LinkedinServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('soapbox/authorize-league');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		StrategyFactory::register('linkedin', 'SoapBox\AuthorizeLeague\LeagueStrategy');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
