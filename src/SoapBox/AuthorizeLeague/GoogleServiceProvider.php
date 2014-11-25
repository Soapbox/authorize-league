<?php namespace SoapBox\AuthorizeLeague;

use Illuminate\Support\ServiceProvider;
use SoapBox\Authorize\StrategyFactory;

class GoogleServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		StrategyFactory::register('google', 'SoapBox\AuthorizeLeague\LeagueStrategy');
	}

}
