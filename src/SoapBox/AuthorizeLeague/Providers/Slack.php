<?php namespace SoapBox\AuthorizeLeague\Providers;

use League\OAuth2\Client\Entity\User;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * Class Slack
 *
 * Backported from https://github.com/adam-paterson/oauth2-slack
 */
class Slack extends AbstractProvider
{
    public $scopes = ['users:read'];

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function urlAuthorize()
    {
        return "https://slack.com/oauth/authorize";
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * @return string
     */
    public function urlAccessToken()
    {
        return "https://slack.com/api/oauth.access";
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     *
     * @return string
     */
    public function urlUserDetails(AccessToken $token)
    {
        $authorizedUser = $this->getAuthorizedUser($token);

        $params = [
            'token' => $token->accessToken,
            'user'  => $authorizedUser->getId()
        ];

        $url = 'https://slack.com/api/users.info?'.http_build_query($params);

        return $url;
    }

    /**
     * @param $token
     *
     * @return string
     */
    public function getAuthorizedUserTestUrl($token)
    {
        return "https://slack.com/api/auth.test?token=".$token;
    }

    /**
     * @param AccessToken $token
     *
     * @return mixed
     */
    public function fetchAuthorizedUserDetails(AccessToken $token)
    {
        $url = $this->getAuthorizedUserTestUrl($token);
        return $this->fetchProviderData($url);
    }

    /**
     * @param AccessToken $token
     *
     * @return SlackAuthorizedUser
     */
    public function getAuthorizedUser(AccessToken $token)
    {
        $response = $this->fetchAuthorizedUserDetails($token);
        return $this->createAuthorizedUser((array) json_decode($response));
    }

    /**
     * @param $response
     *
     * @return SlackAuthorizedUser
     */
    protected function createAuthorizedUser($response)
    {
        return new SlackAuthorizedUser($response);
    }

    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $user = new User();

        $user->exchangeArray([
            'uid' => $response->user->id,
            'name' => $response->user->name,
            'firstname' => $response->user->profile->real_name,
            'lastname' => '',
            'email' => $response->user->profile->email
        ]);

        return $user;
    }
}
