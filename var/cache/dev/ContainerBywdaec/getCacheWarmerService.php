<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'cache_warmer' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/http-kernel/CacheWarmer/CacheWarmerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/http-kernel/CacheWarmer/CacheWarmerAggregate.php';

return $this->services['cache_warmer'] = new \Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerAggregate(new RewindableGenerator(function () {
    yield 0 => ${($_ = isset($this->services['validator.mapping.cache_warmer']) ? $this->services['validator.mapping.cache_warmer'] : $this->load('getValidator_Mapping_CacheWarmerService.php')) && false ?: '_'};
    yield 1 => ${($_ = isset($this->services['translation.warmer']) ? $this->services['translation.warmer'] : $this->load('getTranslation_WarmerService.php')) && false ?: '_'};
    yield 2 => ${($_ = isset($this->services['router.cache_warmer']) ? $this->services['router.cache_warmer'] : $this->load('getRouter_CacheWarmerService.php')) && false ?: '_'};
    yield 3 => ${($_ = isset($this->services['annotations.cache_warmer']) ? $this->services['annotations.cache_warmer'] : $this->load('getAnnotations_CacheWarmerService.php')) && false ?: '_'};
    yield 4 => ${($_ = isset($this->services['doctrine.orm.proxy_cache_warmer']) ? $this->services['doctrine.orm.proxy_cache_warmer'] : $this->load('getDoctrine_Orm_ProxyCacheWarmerService.php')) && false ?: '_'};
}, 5));
