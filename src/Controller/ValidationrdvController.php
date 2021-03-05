<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ValidationrdvController extends AbstractController
{
    /**
     * @Route("/validationrdv", name="validationrdv")
     */
    public function index(Connection $connection): Response
    {

        session_start();

        $rdvPatient = $connection->fetchAll('SELECT date_rdv, status, patientConnexion.nom as patientNom, medecin.id as medecinId, patientConnexion.prenom as patientPrenom, medecin.nom as medecinNom, medecin.prenom as medecinPrenom 
        FROM render_vous, medecin, patientConnexion WHERE render_vous.medecin_id = medecin.id AND patientConnexion.id = render_vous.id_patient AND render_vous.status = "Demande"
        ORDER BY patientNom ASC, date_rdv ASC');



        return $this->render('validationrdv/index.html.twig', [
            'controller_name' => 'ValidationrdvController',
            'rendez' => $rdvPatient,
            'session' => $_SESSION
        ]);
    }
    /**
     * @Route("/refuser", name="refuser")
     */
    public function index1(Connection $connection): Response
    {

        session_start();

        $dateRDV = "". $_GET['date'] . "";

        $db = $this->getDoctrine()->getManager();
            $query = "UPDATE render_vous SET status = 'Refuser' WHERE medecin_id = :medecin AND date_rdv = :dateRdv ";
            $stmt = $db->getConnection()->prepare($query);
            $params = array(
                            'medecin'=>$_GET['medecin'],
                            'dateRdv'=>$dateRDV
                        );
         
            $stmt->execute($params);


        $rdvPatient = $connection->fetchAll('SELECT date_rdv, status, patientConnexion.nom as patientNom, medecin.id as medecinId, patientConnexion.prenom as patientPrenom, medecin.nom as medecinNom, medecin.prenom as medecinPrenom 
        FROM render_vous, medecin, patientConnexion WHERE render_vous.medecin_id = medecin.id AND patientConnexion.id = render_vous.id_patient AND render_vous.status = "Demande"
        ORDER BY patientNom ASC, date_rdv ASC');
        
        return $this->render('validationrdv/index.html.twig', [
            'controller_name' => 'ValidationrdvController',
            'rendez' => $rdvPatient,
            'session' => $_SESSION
        ]);
    }

     /**
     * @Route("/valider", name="valider")
     */
    public function index2(Connection $connection): Response
    {
        session_start();

        $dateRDV = "". $_GET['date'] . "";

        $db = $this->getDoctrine()->getManager();
            $query = "UPDATE render_vous SET status = 'Confirme' WHERE medecin_id = :medecin AND date_rdv = :dateRdv ";
            $stmt = $db->getConnection()->prepare($query);
            $params = array(
                            'medecin'=>$_GET['medecin'],
                            'dateRdv'=>$dateRDV
                        );
         
            $stmt->execute($params);

            $rdvPatient = $connection->fetchAll('SELECT date_rdv, status, patientConnexion.nom as patientNom, medecin.id as medecinId, patientConnexion.prenom as patientPrenom, medecin.nom as medecinNom, medecin.prenom as medecinPrenom 
        FROM render_vous, medecin, patientConnexion WHERE render_vous.medecin_id = medecin.id AND patientConnexion.id = render_vous.id_patient AND render_vous.status = "Demande"
        ORDER BY patientNom ASC, date_rdv ASC');
        
        return $this->render('validationrdv/index.html.twig', [
            'controller_name' => 'ValidationrdvController',
            'rendez' => $rdvPatient,
            'session' => $_SESSION
        ]);
    }
}
