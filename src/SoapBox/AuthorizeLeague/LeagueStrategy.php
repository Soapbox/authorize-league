<?php namespace SoapBox\AuthorizeLeague;

use SoapBox\Authorize\Helpers;
use SoapBox\Authorize\User;
use SoapBox\Authorize\Strategies\SingleSignOnStrategy;
use SoapBox\Authorize\Exceptions\MissingArgumentsException;
use SoapBox\Authorize\Exceptions\AuthenticationException;
use SoapBox\Authorize\Session;
use SoapBox\Authorize\Router;

class LeagueStrategy extends SingleSignOnStrategy {

	private $provider;

	/**
	 * The session that can be used to store session data between
	 * requests / redirects
	 *
	 * @var Session
	 */
	private $session;

	/**
	 * The router that can be used to redirect the user between views
	 *
	 * @var Router
	 */
	private $router;

	public function __construct($parameters = array(), Session $session, Router $router) {
		if( !isset($parameters['api_key']) ||
			!isset($parameters['api_secret']) ||
			!isset($parameters['redirect_url']) ||
			!isset($parameters['provider']) ) {
			throw new MissingArgumentsException(
				'Required parameters api_key, api_secret, redirect_url, or provider are missing'
			);
		}

		$this->provider = ProviderFactory::get($parameters['provider'], $parameters);
		$this->session = $session;
		$this->router = $router;
	}

	public function expects() {
		return ['code'];
	}

	public function login($parameters = array()) {

		if (isset($parameters['code'])) {
			$settings = ['code' => $parameters];

			if ($provider === 'eventbrite') {
				$settings['grant_type'] = 'authorization_code';
			}

			$accessToken = $this->provider->getAccessToken('authorization_code', $settings);
		}

		if (isset($parameters['access_token'])) {
			$accessToken = $parameters['access_token'];
		}

		if (isset($accessToken)) {
			$response = $this->provider->getUserDetails($accessToken);
			if (isset($response)) {
				return $accessToken;
			}
		}

		return false;
	}

	public function getUser($accessToken) {
		if (!$this->isAccessToken($accessToken)) {
			throw new AuthenticationException();
		}

		$response = $this->provider->getUserDetails($accessToken);

		$user = new User;
		$user->id = $response->uid;
		$user->email = $response->email;
		$user->accessToken = json_encode($accessToken);
		$name = explode(' ', $response->name, 2);
		$user->firstname = $name[0];
		$user->lastname = $name[1];

		return $user;
	}
}

