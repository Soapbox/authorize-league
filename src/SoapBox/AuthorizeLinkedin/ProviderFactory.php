<?php namespace SoapBox\AuthorizeLinkedin;

use League\OAuth2\Client\Provider\LinkedIn as LinkedIn;

class ProviderFactory {
	public static function get($provider, array $settings) {
		switch (strtolower($provider)){
			case 'linkedin':
				return new LinkedIn(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
		}
	}
}