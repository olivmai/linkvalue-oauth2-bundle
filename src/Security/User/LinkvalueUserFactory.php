<?php

namespace Linkvalue\Oauth2Bundle\Security\User;

use DateTime;

class LinkvalueUserFactory
{
    public static function create(array $userInfo): LinkvalueUser
    {
        $user = new LinkvalueUser();
        $user->setId($userInfo['id']);
        $user->setFirstName($userInfo['firstName']);
        $user->setLastName($userInfo['lastName']);
        $user->setEmail($userInfo['email']);
        $user->setProfilePictureUrl($userInfo['profilePictureUrl']);
        $user->setTags($userInfo['tags']);
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(DateTime::createFromFormat("Y-m-d", substr($userInfo['createdAt'],0,10)));
        $user->setId($userInfo['id']);
        $user->setId($userInfo['id']);

        return $user;
    }
}
