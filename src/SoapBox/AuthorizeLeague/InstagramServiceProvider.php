<?php namespace SoapBox\AuthorizeLeague;

use Illuminate\Support\ServiceProvider;
use SoapBox\Authorize\StrategyFactory;

class InstagramServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		StrategyFactory::register('instagram', 'SoapBox\AuthorizeLeague\LeagueStrategy');
	}

}
