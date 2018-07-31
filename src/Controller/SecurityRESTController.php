<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityRESTController extends Controller
{
    /**
     * @Route("/api/login", name="login", methods="POST")
     */
    public function loginAction(Request $request)
    {
    }
}
