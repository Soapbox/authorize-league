<?php namespace SoapBox\AuthorizeLinkedin;

use Illuminate\Support\ServiceProvider;
use SoapBox\Authorize\StrategyFactory;

class AuthorizeLinkedinServiceProvider extends ServiceProvider {

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
		$this->package('soapbox/authorize-linkedin');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		StrategyFactory::register('eventbrite', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
		StrategyFactory::register('facebook', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
		StrategyFactory::register('github', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
		StrategyFactory::register('google', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
		StrategyFactory::register('instagram', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
		StrategyFactory::register('linkedin', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
		StrategyFactory::register('microsoft', 'SoapBox\AuthorizeLinkedin\LinkedinStrategy');
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
