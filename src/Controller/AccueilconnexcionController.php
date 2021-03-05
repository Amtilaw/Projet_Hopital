<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilconnexcionController extends AbstractController
{
    /**
     * @Route("/accueilconnexcion", name="accueilconnexcion")
     */
    public function index(): Response
    {
        session_start();

        
        return $this->render('accueilconnexcion/index.html.twig', [
            'controller_name' => 'AccueilconnexcionController',
            'session' => $_SESSION
        ]);
    }

    /**
     * @Route("/deconnection", name="deco")
     */
    public function index1(): Response
    {
        session_start();
        session_unset();
        session_destroy();
        
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilconnexcionController',
        ]);
    }

}
