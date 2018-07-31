<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'console.command.translation_update' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/console/Command/Command.php';
include_once $this->targetDirs[3].'/vendor/symfony/dependency-injection/ContainerAwareInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/framework-bundle/Command/ContainerAwareCommand.php';
include_once $this->targetDirs[3].'/vendor/symfony/framework-bundle/Command/TranslationUpdateCommand.php';

$this->services['console.command.translation_update'] = $instance = new \Symfony\Bundle\FrameworkBundle\Command\TranslationUpdateCommand(${($_ = isset($this->services['translation.writer']) ? $this->services['translation.writer'] : $this->load('getTranslation_WriterService.php')) && false ?: '_'}, ${($_ = isset($this->services['translation.reader']) ? $this->services['translation.reader'] : $this->load('getTranslation_ReaderService.php')) && false ?: '_'}, ${($_ = isset($this->services['translation.extractor']) ? $this->services['translation.extractor'] : $this->load('getTranslation_ExtractorService.php')) && false ?: '_'}, 'en', ($this->targetDirs[3].'/translations'), '');

$instance->setName('translation:update');

return $instance;
