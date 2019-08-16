<?php

namespace Olivmai\LinkvalueOAuth2Bundle\Security\User;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class LinkvalueUserProvider implements UserProviderInterface
{
    private $roles;
    private $security;

    public function __construct(Security $security, array $roles = ['ROLE_USER'])
    {
        $this->roles = $roles;
        $this->security = $security;
    }

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
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return LinkvalueUser::class === $class;
    }
}
