<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'maker.doctrine_helper' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/maker-bundle/src/Doctrine/DoctrineHelper.php';

return $this->services['maker.doctrine_helper'] = new \Symfony\Bundle\MakerBundle\Doctrine\DoctrineHelper('App\\Entity', ${($_ = isset($this->services['doctrine']) ? $this->services['doctrine'] : $this->load('getDoctrineService.php')) && false ?: '_'});