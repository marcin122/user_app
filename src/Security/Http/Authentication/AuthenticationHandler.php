<?php

namespace App\Security\Http\Authentication;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Firebase\JWT\JWT;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @var ContainerInterface 
     */
    private $container;
    
    function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
    }

    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();
        
        $token = [
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + $this->container->getParameter('jwt_ttl')
        ];
        $privateKey = file_get_contents($this->container->getParameter('jwt_private_key'));
        
        $jwt = JWT::encode($token, $privateKey, 'RS256');
        
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setContent(json_encode(['token' => $jwt]));
        $response->setStatusCode(Response::HTTP_OK);
        
        return $response;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setContent(json_encode(['code' => Response::HTTP_UNAUTHORIZED, 'message' => 'BAD_CREDENTIALS']));
        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);
        
        return $response;
    }
}
