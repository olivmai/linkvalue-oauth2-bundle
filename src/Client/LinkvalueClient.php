<?php

namespace Olivmai\LinkvalueOAuth2Bundle\Client;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LinkvalueClient
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    private function getBaseAuthorizationUrl()
    {
        return 'https://lvconnect.link-value.fr/oauth/authorize';
    }

    private function getBaseAccessTokenUrl()
    {
        return 'https://lvconnect.link-value.fr/oauth/token';
    }

    private function getResourceOwnerDetailsUrl()
    {
        return 'https://lvconnect.link-value.fr/users/me';
    }

    /**
     * @param array $queryParameters
     * @return RedirectResponse
     */
    public function getAuthorizationCode(array $queryParameters)
    {
        return new RedirectResponse(sprintf(
            '%s?client_id=%s&response_type=code&redirect_uri=%s',
            $this->getBaseAuthorizationUrl(),
            $queryParameters['client_id'],
            $queryParameters['redirect_uri']
        ));
    }

    public function getToken(array $queryParameters): string
    {
        $response = $this->client->request('POST', $this->getBaseAccessTokenUrl(), [
            'body' => [
                'grant_type' => 'authorization_code',
                'code' => $queryParameters['code'],
                'client_id' => $queryParameters['client_id'],
                'client_secret' => $queryParameters['client_secret'],
            ]
        ]);

        return $response->toArray()['access_token'];
    }

    public function getUserInfos(string $accessToken): array
    {
        $response = $this->client->request('GET', $this->getResourceOwnerDetailsUrl(), [
            'headers' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]
        ]);

        return $response->toArray();
    }
}