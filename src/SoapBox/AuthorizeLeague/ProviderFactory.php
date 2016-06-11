<?php namespace SoapBox\AuthorizeLeague;

use SoapBox\AuthorizeLeague\Providers\Slack;
use League\OAuth2\Client\Provider\Github as Github;
use League\OAuth2\Client\Provider\Google as Google;
use League\OAuth2\Client\Provider\Facebook as Facebook;
use League\OAuth2\Client\Provider\LinkedIn as LinkedIn;
use League\OAuth2\Client\Provider\Instagram as Instagram;
use League\OAuth2\Client\Provider\Microsoft as Microsoft;
use League\OAuth2\Client\Provider\Eventbrite as Eventbrite;

class ProviderFactory {
	public static function get($provider, array $settings) {
		switch (strtolower($provider)) {
			case 'eventbrite':
				return new Eventbrite(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
			case 'facebook':
				return new Facebook(array(
					'clientId'		=>	$settings['id'],
					'clientSecret'	=>	$settings['secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
			case 'github':
				return new Github(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url'],
					'scopes'		=>	['user']
				));
			case 'google':
				return new Google(array(
					'clientId'		=>	$settings['id'],
					'clientSecret'	=>	$settings['secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
			case 'instagram':
				return new Instagram(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
			case 'linkedin':
				return new LinkedIn(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url'],
					'scopes'		=>	['r_basicprofile', 'r_emailaddress']
				));
			case 'microsoft':
				return new Microsoft(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
			case 'slack':
				return new Slack(array(
					'clientId'		=>	$settings['api_key'],
					'clientSecret'	=>	$settings['api_secret'],
					'redirectUri'	=>	$settings['redirect_url']
				));
		}
	}
}
