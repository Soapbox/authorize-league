<?php namespace SoapBox\AuthorizeLeague\Providers;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Slack
 */
class Slack extends AbstractProvider
{
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
            'token' => $token->getToken(),
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
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     *
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     *
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {

    }

    /**
     * Create new resources owner using the generated access token.
     *
     * @param array $response
     * @param AccessToken $token
     *
     * @return SlackResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new SlackResourceOwner($response);
    }

    /**
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['users:read'];
    }

    /**
     * @param AccessToken $token
     *
     * @return mixed
     */
    public function fetchAuthorizedUserDetails(AccessToken $token)
    {
        $url = $this->getAuthorizedUserTestUrl($token);

        $request = $this->getAuthenticatedRequest(self::METHOD_GET, $url, $token);

        return $this->getResponse($request);
    }

    /**
     * @param AccessToken $token
     *
     * @return SlackAuthorizedUser
     */
    public function getAuthorizedUser(AccessToken $token)
    {
        $response = $this->fetchAuthorizedUserDetails($token);

        return $this->createAuthorizedUser($response);
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
        dd($response);
        $slack = $this->createAuthorizedUser($response);
        $user = new User();

        $user->exchangeArray([
            'uid' => $slack->getId(),
            'name' => $slack->getUser(),
            'firstname' => $slack->getUser(),
            'lastname' => $slack->getUser(),
            'email' => $email,
            'location' => $location,
            'description' => $description,
            'imageurl' => $imageUrl,
            'gender' => $gender,
            'locale' => $locale,
            'urls' => [ 'Facebook' => $response->link ],
        ]);

        return $user;
        return $user;
    }
}
