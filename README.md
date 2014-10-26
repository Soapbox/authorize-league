# Authorize-League
[Authorize-League](http://github.com/soapbox/authorize-league) a collection of oauth login providers.

## Getting Started
- Install [Authorize](http://github.com/soapbox/authorize) into your application
to use this Strategy.
- Configure applications online for each of the providers you wish to integrate

## Installation
Add the following to your `composer.json`
```
"require": {
	...
	"soapbox/authorize-league": "0.*",
	...
}
```

### app/config/app.php
Add the following to your `app.php`, note this will be removed in future
versions since it couples us with Laravel, and it isn't required for the library
to function

#### EventBrite support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\EventBriteServiceProvider",
	...
)
```

#### Facebook support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\FacebookServiceProvider",
	...
)
```

#### Github support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\GithubServiceProvider",
	...
)
```

#### Google support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\GoogleServiceProvider",
	...
)
```

#### Instagram support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\InstagramServiceProvider",
	...
)
```

#### Linkedin support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\LinkedinServiceProvider",
	...
)
```

#### Microsoft support
```
'providers' => array(
	...
	"SoapBox\AuthorizeLeague\MicrosoftServiceProvider",
	...
)
```

## Usage

### Login
```php

use SoapBox\Authroize\Authenticator;
use SoapBox\Authorize\Exceptions\InvalidStrategyException;
...
$settings = [
	'api_key' => 'APPID',
	'api_secret' => 'APPSECRET',
	'redirect_url' => 'http://example.com/social/facebook/callback',
	'provider' => 'eventbrite' // ['eventbrite', 'facebook', 'github', 'google', 'instagram', 'linkedin', 'microsoft']
];

//If you already have an accessToken from a previous authentication attempt
$parameters = ['accessToken' => 'sometoken'];

$strategy = new Authenticator('eventbrite', $settings); // See provider list above

$user = $strategy->authenticate($parameters);

```

### Endpoint
```php

use SoapBox\Authroize\Authenticator;
use SoapBox\Authorize\Exceptions\InvalidStrategyException;
...
$settings = [
	'api_key' => 'APPID',
	'api_secret' => 'APPSECRET',
	'redirect_url' => 'http://example.com/social/facebook/callback',
	'provider' => 'eventbrite' // ['eventbrite', 'facebook', 'github', 'google', 'instagram', 'linkedin', 'microsoft']
];

$strategy = new Authenticator('eventbrite', $settings); // See provider list above
$user = $strategy->endpoint();

```
