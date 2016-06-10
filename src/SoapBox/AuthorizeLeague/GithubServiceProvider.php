<?php namespace SoapBox\AuthorizeLeague;

use Illuminate\Support\ServiceProvider;
use SoapBox\Authorize\StrategyFactory;

class GithubServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		StrategyFactory::register('github', 'SoapBox\AuthorizeLeague\LeagueStrategy');
	}

}
