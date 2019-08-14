<?php

namespace Linkvalue\Oauth2Bundle\Provider;

use App\Oauth\Client\LinkvalueClient;
use App\Oauth\Security\User\LinkvalueUser;
use App\Oauth\Security\User\LinkvalueUserFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LinkvalueProvider
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var array
     */
    private $scopes;

    /**
     * @var LinkvalueClient
     */
    private $linkvalueClient;

    public function __construct(
        LinkvalueClient $linkvalueClient,
        string $clientId,
        string $clientSecret,
        string $redirectUri = null,
        array $scopes = []
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->scopes = $scopes;
        $this->linkvalueClient = $linkvalueClient;
    }

    public function redirect(): RedirectResponse
    {
        return $this->linkvalueClient->getAuthorizationCode($this->getAuthorizationParameters());
    }

    public function fetchUser(string $accessToken): LinkvalueUser
    {
        $userInfo = $this->linkvalueClient->getUserInfos($accessToken);
        $linkvalueUser = LinkvalueUserFactory::create($userInfo);

        return $linkvalueUser;
    }

    private function getAuthorizationParameters(): array
    {
        return [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
        ];
    }

    private function getTokenParameters(string $code): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
        ];
    }

    public function getAccessToken(string $code): string
    {
        return $this->linkvalueClient->getToken($this->getTokenParameters($code));
    }
}
