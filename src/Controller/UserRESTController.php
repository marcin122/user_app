<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use App\Entity\User;
use App\Annotation\Rest;
use App\Form\UserType;

/**
 * @Route("/api/users")
 */
class UserRESTController extends Controller
{
    /**
     * @var EntityManagerInterface 
     */
    private $em;
    
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }
    
    /**
     * @Route("/{user}", name="get_user", methods="GET", requirements={"user"="\d+"})
     * @Rest(serializerGroups={"USER_MODEL"}, entity=User::class, parameter="user")
     */
    public function getAction(Request $request, User $user)
    {
        return [$user, Response::HTTP_OK];
    }
    
    /**
     * @Route("", name="cget_user", methods="GET")
     * @Rest(serializerGroups={"USER_MODEL"}, entity=User::class)
     */
    public function cgetAction(Request $request)
    {
        $users = $this->em->getRepository(User::class)->findAll();
        
        return [$users, Response::HTTP_OK];
    }
    
    /**
     * @Route("", name="post_user", methods="POST")
     * @Rest(serializerGroups={"USER_MODEL"}, entity=User::class)
     */
    public function postAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->getContent());
        if ($form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $this->em->persist($user);
            $this->em->flush();
            
            return [$user, Response::HTTP_CREATED];
        }
        
        return [$form->getErrors(true), Response::HTTP_BAD_REQUEST];
    }
    
    /**
     * @Route("/{user}", name="put_user", methods="PUT", requirements={"id"="\d+"})
     * @Rest(serializerGroups={"USER_MODEL"}, entity=User::class, parameter="user")
     */
    public function putAction(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->submit($request->getContent());
        if ($form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $this->em->flush();
            
            return [$user, Response::HTTP_OK];
        }
        
        [$form->getErrors(true), Response::HTTP_BAD_REQUEST];
    }
    
    /**
     * @Route("/{user}", name="delete_user", methods="DELETE", requirements={"id"="\d+"})
     * @Rest(serializerGroups={"USER_MODEL"}, entity=User::class, parameter="user")
     */
    public function deleteAction(Request $request, User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
        
        return [null, Response::HTTP_OK];
    }
}
