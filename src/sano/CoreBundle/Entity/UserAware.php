<?php

namespace sano\CoreBundle\Entity;

interface UserAware
{
    public function setUser(UserInterface $user = null);
}
