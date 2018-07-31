<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class srcDevDebugProjectContainerUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    private static $declaredRoutes;

    public function __construct(RequestContext $context, LoggerInterface $logger = null)
    {
        $this->context = $context;
        $this->logger = $logger;
        if (null === self::$declaredRoutes) {
            self::$declaredRoutes = array(
        'login' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'App\\Controller\\SecurityRESTController::loginAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/login',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'get_user' => array (  0 =>   array (    0 => 'user',  ),  1 =>   array (    '_controller' => 'App\\Controller\\UserRESTController::getAction',  ),  2 =>   array (    'user' => '\\d+',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '\\d+',      3 => 'user',    ),    1 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'cget_user' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'App\\Controller\\UserRESTController::cgetAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'post_user' => array (  0 =>   array (  ),  1 =>   array (    '_controller' => 'App\\Controller\\UserRESTController::postAction',  ),  2 =>   array (  ),  3 =>   array (    0 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'put_user' => array (  0 =>   array (    0 => 'user',  ),  1 =>   array (    '_controller' => 'App\\Controller\\UserRESTController::putAction',  ),  2 =>   array (    'id' => '\\d+',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'user',    ),    1 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
        'delete_user' => array (  0 =>   array (    0 => 'user',  ),  1 =>   array (    '_controller' => 'App\\Controller\\UserRESTController::deleteAction',  ),  2 =>   array (    'id' => '\\d+',  ),  3 =>   array (    0 =>     array (      0 => 'variable',      1 => '/',      2 => '[^/]++',      3 => 'user',    ),    1 =>     array (      0 => 'text',      1 => '/api/users',    ),  ),  4 =>   array (  ),  5 =>   array (  ),),
    );
        }
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        if (!isset(self::$declaredRoutes[$name])) {
            throw new RouteNotFoundException(sprintf('Unable to generate a URL for the named route "%s" as such route does not exist.', $name));
        }

        list($variables, $defaults, $requirements, $tokens, $hostTokens, $requiredSchemes) = self::$declaredRoutes[$name];

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }
}
