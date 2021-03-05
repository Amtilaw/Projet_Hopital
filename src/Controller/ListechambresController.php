<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;

class ListechambresController extends AbstractController
{
    /**
     * @Route("/listechambres", name="listechambres")
     */
    public function index(Connection $connection): Response
    {
        $id_service = $_GET['num'];
        $chambres = $connection->fetchAll('SELECT * FROM chambre
        WHERE id_service = '. $id_service .' ');

        $service_name = $connection->fetchAll('SELECT name FROM services
        WHERE id = '. $id_service .' ');

        return $this->render('listechambres/index.html.twig', [
            'controller_name' => 'ListechambresController',
            'chambres' => $chambres,
            'service_name' => $service_name
        ]);
    }
}
