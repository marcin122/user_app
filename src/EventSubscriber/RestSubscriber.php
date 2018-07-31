<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Annotation\Rest;
use App\Annotation\RestGroups;

class RestSubscriber implements EventSubscriberInterface 
{
    /**
     * @var Reader 
     */
    private $reader;
    
    /**
     * @var EntityManagerInterface 
     */
    private $em;
    
    private $annotationData;
            
    function __construct(Reader $reader, EntityManagerInterface $em) 
    {
        $this->reader = $reader;
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::VIEW => 'onKernelView',
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $body = json_decode($request->getContent(), true);
        
        $request->initialize(
            $request->query->all(),
            $request->request->all(),
            $request->attributes->all(),
            $request->cookies->all(),
            $request->files->all(),
            $request->server->all(),
            $body
        );
    }
    
    public function onKernelController(FilterControllerEvent $event)
    {
        list($controller, $methodName) = $event->getController();
        $request = $event->getRequest();
        $reflectionControllerObject = new \ReflectionObject($controller);
        $reflectionControllerMethod = $reflectionControllerObject->getMethod($methodName);
        $this->annotationData = $this->reader
            ->getMethodAnnotation($reflectionControllerMethod, Rest::class);
        
        if (preg_match('/^cget|^post/', $request->attributes->get('_route'))) {
            return;
        }
        
        $object = $this->em->getRepository($this->annotationData->entity)->findOneById($request->attributes->get($this->annotationData->parameter));
        if (empty($object)) {
            throw new NotFoundHttpException('OBJECT_NOT_FOUND');
        }
        $request->attributes->set($this->annotationData->parameter, $object);
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $value = $event->getControllerResult();
        list($data, $statusCode) = $value;
        
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setStatusCode($statusCode);
        
        if (is_array($data)) {
            $list = [];
            foreach ($data as $row) {
                $list[] = $this->serializeObject($row);
            }
            $response->setContent(json_encode($list));
        } elseif (is_object($data)) {
            $response->setContent(json_encode($this->serializeObject($data)));
        }
        
        $event->setResponse($response);
    }
    
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setContent(json_encode(['code' => method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500, 'message' => $exception->getMessage()]));
        
        $event->setResponse($response);
    }
    
    private function serializeObject($object)
    {
        $objectData = [];
        $reflectionObject = new \ReflectionObject($object);
        $reflectionClass = new \ReflectionClass($reflectionObject->getName());
        foreach ($reflectionClass->getProperties() as $property) {
            $propertyData = $this->reader->getPropertyAnnotation($property, RestGroups::class);
            if (empty($propertyData)) {
                continue;
            }
            if (!empty(array_intersect($this->annotationData->serializerGroups,$propertyData->groups))) {
                $property->setAccessible(true);
                $objectData[$property->name] = $property->getValue($object);
            }
        }
        
        return $objectData;
    }
}
