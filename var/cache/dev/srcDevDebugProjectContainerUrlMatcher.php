<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class srcDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($rawPathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $trimmedPathinfo = rtrim($pathinfo, '/');
        $context = $this->context;
        $request = $this->request ?: $this->createRequest($pathinfo);
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        // login
        if ('/api/login' === $pathinfo) {
            $ret = array (  '_controller' => 'App\\Controller\\SecurityRESTController::loginAction',  '_route' => 'login',);
            if (!in_array($requestMethod, array('POST'))) {
                $allow = array_merge($allow, array('POST'));
                goto not_login;
            }

            return $ret;
        }
        not_login:

        if (0 === strpos($pathinfo, '/api/users')) {
            // get_user
            if (preg_match('#^/api/users/(?P<user>\\d+)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'get_user')), array (  '_controller' => 'App\\Controller\\UserRESTController::getAction',));
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_get_user;
                }

                return $ret;
            }
            not_get_user:

            // cget_user
            if ('/api/users' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\UserRESTController::cgetAction',  '_route' => 'cget_user',);
                if (!in_array($canonicalMethod, array('GET'))) {
                    $allow = array_merge($allow, array('GET'));
                    goto not_cget_user;
                }

                return $ret;
            }
            not_cget_user:

            // post_user
            if ('/api/users' === $pathinfo) {
                $ret = array (  '_controller' => 'App\\Controller\\UserRESTController::postAction',  '_route' => 'post_user',);
                if (!in_array($requestMethod, array('POST'))) {
                    $allow = array_merge($allow, array('POST'));
                    goto not_post_user;
                }

                return $ret;
            }
            not_post_user:

            // put_user
            if (preg_match('#^/api/users/(?P<user>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'put_user')), array (  '_controller' => 'App\\Controller\\UserRESTController::putAction',));
                if (!in_array($requestMethod, array('PUT'))) {
                    $allow = array_merge($allow, array('PUT'));
                    goto not_put_user;
                }

                return $ret;
            }
            not_put_user:

            // delete_user
            if (preg_match('#^/api/users/(?P<user>[^/]++)$#sD', $pathinfo, $matches)) {
                $ret = $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_user')), array (  '_controller' => 'App\\Controller\\UserRESTController::deleteAction',));
                if (!in_array($requestMethod, array('DELETE'))) {
                    $allow = array_merge($allow, array('DELETE'));
                    goto not_delete_user;
                }

                return $ret;
            }
            not_delete_user:

        }

        if ('/' === $pathinfo && !$allow) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
