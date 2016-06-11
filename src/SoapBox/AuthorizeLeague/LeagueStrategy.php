<?php namespace SoapBox\AuthorizeLeague;

use SoapBox\Authorize\Helpers;
use SoapBox\Authorize\User;
use SoapBox\Authorize\Strategies\SingleSignOnStrategy;
use SoapBox\Authorize\Exceptions\MissingArgumentsException;
use SoapBox\Authorize\Exceptions\AuthenticationException;

class LeagueStrategy extends SingleSignOnStrategy {

	private $provider;

	public static $store = null;
	public static $load = null;

	public function __construct($parameters = array(), $store = null, $load = null) {
		if( !isset($parameters['api_key']) ||
			!isset($parameters['api_secret']) ||
			!isset($parameters['redirect_url']) ||
			!isset($parameters['provider']) ) {
			throw new MissingArgumentsException(
				'Required parameters api_key, api_secret, redirect_url, or provider are missing'
			);
		}

		$this->provider = ProviderFactory::get($parameters['provider'], $parameters);

		if ($store != null && $load != null) {
			LeagueStrategy::$store = $store;
			LeagueStrategy::$load = $load;
		} else {
			session_start();
			LeagueStrategy::$store = function($key, $value) {
				$_SESSION[$key] = $value;
			};
			LeagueStrategy::$load = function($key) {
				return $_SESSION[$key];
			};
		}
	}

	public function login($parameters = array()) {
		return $this->endPoint($parameters);
	}

	public function getUser($parameters = array()) {
		if (!isset($parameters['accessToken'])) {
			throw new AuthenticationException();
		}

		$accessToken = $parameters['accessToken'];
		$response = $this->provider->getUserDetails($accessToken);

		$user = new User;
		$user->id = $response->uid;
		$user->email = $response->email;
		$user->accessToken = json_encode($accessToken);
		$name = explode(' ', $response->name, 2);
		$user->firstname = (isset($name[0])) ? $name[0] : '';
		$user->lastname = (isset($name[1])) ? $name[1] : '';

		return $user;
	}

	public function endPoint($parameters = array()) {

		if ( !isset($_GET['code'])) {

			Helpers::redirect($this->provider->getAuthorizationUrl());

		} else {
			// Try to get the access token using auth code
			if(strtolower($parameters['provider']) == 'eventbrite') {
				$accessToken =  $this->provider->getAccessToken('authorization_code', [
					'code' => $_GET['code'],
					'grant_type' => 'authorization_code'
				]);
			} else {
				$accessToken =  $this->provider->getAccessToken('authorization_code', [
					'code' => $_GET['code']
				]);
			}
		}

		return $this->getUser(['accessToken' => $accessToken]);
	}
}

