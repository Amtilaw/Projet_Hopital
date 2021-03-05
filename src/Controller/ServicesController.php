<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;

class ServicesController extends AbstractController
{
    /**
     * @Route("/services", name="services")
     */
    public function index(Connection $connection): Response
    {
        $services = $connection->fetchAll('SELECT * FROM services');

        $chambres = $connection->fetchAll('SELECT * FROM chambre');

        return $this->render('services/index.html.twig', [
            'controller_name' => 'ServicesController',
            'services' => $services,
            'chambres' => $chambres
        ]);
    }
}
