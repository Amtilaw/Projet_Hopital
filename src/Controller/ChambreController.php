<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;

class ChambreController extends AbstractController
{
    /**
     * @Route("/chambre", name="chambre")
     */
    public function index(Connection $connection): Response
    {
        $services = $connection->fetchAll('SELECT name, id FROM services WHERE id = '. $_GET['numService'] .'');

        $lits = $connection->fetchAll('SELECT * FROM lit WHERE chambre_id = '. $_GET['numChambre'] .'');

        $patients = $connection->fetchAll('SELECT * FROM patient, lit WHERE patient.id_patient = lit.patient_id AND
                                            lit.chambre_id = '.$_GET['numChambre'] .'');

        if (empty($lits)){
            $lits[0]['chambre_id'] = -1;
        }

        return $this->render('chambre/index.html.twig', [
            'controller_name' => 'ChambreController',
            'service_name' => $services,
            'lits' => $lits,
            'patient' => $patients,
            'numChambre' => $_GET['numChambre']
        ]);
    }

    /**
     * @Route("/supprimer", name="supprimer")
     */

    public function index1(Connection $connection): Response
    {
            
            $db = $this->getDoctrine()->getManager();
            $query = 'DELETE FROM `lit` WHERE patient_id = '. $_GET['patient'] .'';
            $stmt = $db->getConnection()->prepare($query);
            $stmt->execute();
        return $this->redirectToRoute('chambre', ['numService' => $_GET['numService'], 'numChambre' => $_GET['numChambre']]);
    }
}
