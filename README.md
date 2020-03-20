# LV Connect OAuth provider

This package provides Linvalue OAuth 2.0 support for an authentication through [LV Connect](https://github.com/Linkvalue-Interne/LvConnect).

## Installation

```sh
composer require olivmai/linkvalue-oauth2-bundle
```

## Usage

### Register the new Bundle
```php
# config/bundles.php
return [
    /* ... */
    Olivmai\LinkvalueOAuth2Bundle\LinkvalueOAuth2Bundle::class => ['all' => true],
];
```

### Add Configuration file
Create a configuration file named linkvalue_oauth2.yaml in the config/packages directory and then fill it with the following :

```yaml
# config/packeges/linkvalue_oauth2.yaml
linkvalue_oauth2:
    client_id: '%env(resolve:OAUTH_LINKVALUE_APP_ID)%'
    client_secret: '%env(resolve:OAUTH_LINKVALUE_APP_SECRET)%'
    redirect_uri: '%env(resolve:OAUTH_LINKVALUE_REDIRECT_URL)%'
    scopes: '%env(resolve:OAUTH_LINKVALUE_SCOPE)%'
```
Finally, make sure you have the env variables configured in your project

### Add a controller
The minimum controller code could look like that. connectCheckAction is empty because we use a guard authnetication based but you are free to implement your own logic here if needed.
```php
<?php

namespace App\Controller;

use Olivmai\LinkvalueOAuth2Bundle\Provider\LinkvalueProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LinkvalueController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/linkvalue", name="connect_linkvalue_start")
     * @param LinkvalueProvider $linkvalueProvider
     * @return RedirectResponse
     */
    public function connectAction(LinkvalueProvider $linkvalueProvider): RedirectResponse
    {
        // redirect to LV Connect and then back to connect_linkvalue_check, see below
        return $linkvalueProvider->redirect();
    }

    /**
     * @Route("/connect/linkvalue/check", name="connect_linkvalue_check")
     * @param Request $request
     * @param LinkvalueProvider $linkvalueProvider
     */
    public function connectCheckAction(Request $request, LinkvalueProvider $linkvalueProvider)
    {
        // leave this method blank to authenticate through Guard authenticator
    }
}

```

### Symfony security configuration
You then need to add reference to appropriate User provider and guard authenticator in security.yaml file as follow
```yaml
security:
    # ...
    providers:
        # ...
        linkvalue_provider:
            id: Olivmai\LinkvalueOAuth2Bundle\Security\User\LinkvalueUserProvider
    firewalls:
        # ...
        yourfirewall:
            # ...
            guard:
                authenticators:
                    - Olivmai\LinkvalueOAuth2Bundle\Security\Authenticator\LinkvalueAuthenticator
            provider: linkvalue_provider
            logout:
                path: app_logout
                target: login
            
```

### Done !
That's it, you now can log ing through LV Connect authentication.
This simple implementation does not provide database user storage. The authenticated user only has an email to be identified.
If you need more information about the user and/or need to store information in database, you can implement your own logic with your own UserProvider and/or your own Authenticator.
The ```fetchUser()``` method called during authentication in ```LinkvalueProvider``` class return a LinkvalueUser like this :
```php
LinkvalueUser :
  -id: "xxxxx"                 // string
  -firstName: "xxxxx"           // string
  -lastName: "XXXXX"           // string
  -email: "xxxxx@xxxxx.xx"     // string
  -profilePictureUrl: "xxxxxx"  // string (url to profile picture)
  -tags: []                    // array
  -roles: []                   // array
  -createdAt: DateTime         // DateTime
  -city: null                  // string|null
  -job: null                   // string|null
}
```

## Credits

- [Olivier Mairet](https://github.com/olivmai)

## License

The MIT License (MIT).
