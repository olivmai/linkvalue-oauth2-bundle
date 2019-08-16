<?php

namespace Olivmai\LinkvalueOAuth2Bundle\Security\User;

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
        if (key_exists('tags', $userInfo)) {
            $user->setTags($userInfo['tags']);
        }
        $user->setRoles(['ROLE_USER']);
        if (key_exists('createdAt', $userInfo)) {
            $user->setCreatedAt(DateTime::createFromFormat("Y-m-d", substr($userInfo['createdAt'],0,10)));
        }

        return $user;
    }
}
