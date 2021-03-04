<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{

    /**
     * @Route("/frontacceuil", name="frontacceuil")
     */
    public function frontend(): Response
    {
        return $this->render('frontend/frontbody.html.twig', [
            'controller_name' => 'RedirectController',
        ]);
    }
    /**
     * @Route("/backacceuil", name="backacceuil")
     */
    public function backend(): Response
    {
        return $this->render('backend/backbody.html.twig', [
            'controller_name' => 'RedirectController',
        ]);
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(): Response
    {
        return $this->render('signup/signup.html.twig', [
            'controller_name' => 'RedirectController',
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('login/login.html.twig', [
            'controller_name' => 'RedirectController',
        ]);
    }


}
