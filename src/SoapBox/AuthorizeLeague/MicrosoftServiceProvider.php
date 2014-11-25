<?php namespace SoapBox\AuthorizeLeague;

use Illuminate\Support\ServiceProvider;
use SoapBox\Authorize\StrategyFactory;

class AuthorizeLeagueServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		StrategyFactory::register('microsoft', 'SoapBox\AuthorizeLeague\LeagueStrategy');
	}

}
