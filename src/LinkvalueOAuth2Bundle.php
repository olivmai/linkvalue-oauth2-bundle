<?php

namespace Olivmai\LinkvalueOAuth2Bundle;

use Olivmai\LinkvalueOAuth2Bundle\DependencyInjection\LinkvalueOauth2Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LinkvalueOAuth2Bundle extends Bundle
{
    /**
     * @return LinkvalueOauth2Extension
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            return new LinkvalueOauth2Extension();
        }

        return $this->extension;
    }
}
