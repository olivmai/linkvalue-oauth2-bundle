<?php

namespace Olivmai\LinkvalueOAuth2Bundle\Security\User;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class LinkvalueUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $user = new LinkvalueUser();
        $user->setEmail($username);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof LinkvalueUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        
        return $user;
    }

    public function supportsClass($class)
    {
        return LinkvalueUser::class === $class;
    }
}
