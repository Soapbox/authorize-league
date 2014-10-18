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

	// public function login($parameters = array()) {
	// 	$store = TwitterStrategy::$store;

	// 	if ( !isset($parameters['redirect_url']) ) {
	// 		throw new MissingArgumentsException(
	// 			'redirect_url is required'
	// 		);
	// 	}

	// 	$requestToken = $this->twitter->getRequestToken($parameters['redirect_url']);

	// 	$store('twitter.oauth_token', $requestToken['oauth_token']);
	// 	$store('twitter.oauth_token_secret', $requestToken['oauth_token_secret'], true);

	// 	$token = $requestToken['oauth_token'];

	// 	switch ($this->twitter->http_code) {
	// 		case 200:
	// 			Helpers::redirect($this->twitter->getAuthorizeURL($token, true));
	// 			break;
	// 		default:
	// 			throw new AuthorizationException();
	// 	}
	// }


}