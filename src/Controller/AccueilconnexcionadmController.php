<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilconnexcionadmController extends AbstractController
{
    /**
     * @Route("/accueilconnexcionadm", name="accueilconnexcionadm")
     */
    public function index(): Response
    {
        session_start();
        return $this->render('accueilconnexcionadm/index.html.twig', [
            'controller_name' => 'AccueilconnexcionadmController',
            'session' => $_SESSION
        ]);
    }
}
