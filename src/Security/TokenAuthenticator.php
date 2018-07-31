<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Firebase\JWT\JWT;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ContainerInterface 
     */
    private $container;
    
    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
    }
    
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }

    public function getCredentials(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        $data = explode(' ', $authorizationHeader);
        
        if (count($data) > 1 && $data[0] === 'Bearer') {
            return ['token' => $data[1]];
        }

        throw new AuthenticationException('JWT_TOKEN_NOT_FOUND');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $credentials['token'];
        
        $publicKey = file_get_contents($this->container->getParameter('jwt_public_key'));
        try {
            $decoded = JWT::decode($token, $publicKey, ['RS256']);      
        } catch (\Exception $ex) {
            throw new AuthenticationException('INVALID_JWT_TOKEN');
        }

        return $userProvider->loadUserByUsername($decoded->username);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setContent(json_encode(['code' => Response::HTTP_UNAUTHORIZED, 'message' => $exception->getMessage()]));
        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);

        return $response;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setContent(json_encode(['code' => Response::HTTP_UNAUTHORIZED, 'message' => 'JWT_TOKEN_NOT_FOUND']));
        $response->setStatusCode(Response::HTTP_UNAUTHORIZED);

        return $response;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
