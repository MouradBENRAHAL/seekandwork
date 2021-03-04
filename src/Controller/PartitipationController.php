<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartitipationController extends AbstractController
{
    /**
     * @Route("/partitipation", name="partitipation")
     */
    public function index(): Response
    {
        return $this->render('partitipation/index.html.twig', [
            'controller_name' => 'PartitipationController',
        ]);
    }
}
