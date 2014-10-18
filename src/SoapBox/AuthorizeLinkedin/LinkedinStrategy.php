<?php namespace SoapBox\AuthorizeLinkedin;

use SoapBox\Authorize\Strategies\SingleSignOnStrategy;
use League\OAuth2\Client\Provider\LinkedIn as LinkedIn;

class LinkedinStrategy extends SingleSignOnStrategy {

	private $linkedin;

	public static $store = null;
	public static $load = null;

	public function __construct($parameters = array(), $store = null, $load = null) {
		if( !isset($parameters['api_key']) ||
			!isset($parameters['api_secret']) ||
			!isset($parameters['redirect_uri']) ) {
			throw new MissingArgumentsException(
				'Required parameters api_key, or api_secret, or redirect_uri are missing'
			);
		}

		$this->linkedin = new LinkedIn(array(
			'clientId'		=>	$parameters['api_key'],
			'clientSecret'	=>	$parameters['api_secret'],
			'redirectUri'	=>	$parameters['redirect_uri']
		));

		if ($store != null && $load != null) {
			LinkedinStrategy::$store = $store;
			LinkedinStrategy::$load = $load;
		} else {
			session_start();
			LinkedinStrategy::$store = function($key, $value) {
				$_SESSION[$key] = $value;
			};
			LinkedinStrategy::$load = function($key) {
				return $_SESSION[$key];
			};
		}

		$this->linkedin->host = 'https://api.linkedin.com/';
	}

	public function login($parameters = array()) {
		$store = LinkedinStrategy::$store;

		if ( !isset($parameters['redirect_url']) ) {
			throw new MissingArgumentsException(
				'redirect_url is required'
			);
		}


		if ( !isset($_GET['code'])) {

			$this->linkedin->authorize();

		} else {
			// Try to get the access token using auth code

			$requestToken =  $this->twitter->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
		}

		return $this->getUser(['requestToken' => $requestToken]);
	}

	public function getUser($parameters = array()) {
		if (!isset($parameters['requestToken'])) {
			throw new AuthenticationException();
		}

		$requestToken = $parameters['requestToken'];
		$response = $provider->getUserDetails($requestToken);

		dd($response);

		$user = new User;
		$user->id = $response->getProperty('id');
		$user->email = $response->getProperty('email');
		$user->requestToken = $parameters['requestToken'];
		$user->firstname = $response->getProperty('first_name');
		$user->lastname = $response->getProperty('last_name');

		return $user;
	}
}