<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Annotation\RestGroups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @UniqueEntity("username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @RestGroups({"USER_MODEL"})
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", unique=true)
     * 
     * @RestGroups({"USER_MODEL"})
     * 
     * @Assert\NotBlank
     */
    private $username;
    
    /**
     * @ORM\Column(type="string")
     * 
     * @Assert\NotBlank
     */
    private $password;
    
    /**
     * @ORM\Column(type="array")
     * 
     * @RestGroups({"USER_MODEL"})
     */
    private $roles;
    
    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function eraseCredentials()
    {
    }
}
