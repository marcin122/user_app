<?php

namespace App\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class WebserviceUserProvider implements UserProviderInterface 
{
    /**
     * @var EntityManagerInterface 
     */
    private $em;
    
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }
    
    public function loadUserByUsername($username)
    {
        return $this->fetchUser($username);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->fetchUser($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
    
    private function fetchUser($username)
    {
        $user = $this->em->getRepository(User::class)->findOneByUsername($username);
        
        if (!empty($user)) {
            return $user;
        }
        
        throw new UsernameNotFoundException('USER_DOES_NOT_EXIST');
    }
}
