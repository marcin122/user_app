<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'App\Security\TokenAuthenticator' shared autowired service.

include_once $this->targetDirs[3].'/vendor/symfony/security/Http/EntryPoint/AuthenticationEntryPointInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security/Guard/GuardAuthenticatorInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security/Guard/AuthenticatorInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security/Guard/AbstractGuardAuthenticator.php';
include_once $this->targetDirs[3].'/src/Security/TokenAuthenticator.php';

return $this->services['App\Security\TokenAuthenticator'] = new \App\Security\TokenAuthenticator($this);
