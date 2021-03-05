<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConsultationrdvController extends AbstractController
{
    /**
     * @Route("/consultationrdv", name="consultationrdv")
     */
    public function index(Connection $connection): Response
    {
        session_start();

        $rdvPatient = $connection->fetchAll('SELECT * FROM render_vous, medecin WHERE id_patient = '. $_SESSION['id_patient'] .' AND render_vous.medecin_id = medecin.id');

        if (empty($rdvPatient)) {
            $rdvPatient[0]['medecin_id'] = null;
            $rdvPatient[0]['date_rdv'] = null;
            $rdvPatient[0]['id_patient'] = null;
        }

        return $this->render('consultationrdv/index.html.twig', [
            'controller_name' => 'ConsultationrdvController',
            'rendez' => $rdvPatient,
            'session' => $_SESSION
        ]);
    }
     /**
     * @Route("/annule", name="annule")
     */
    public function index2(Connection $connection): Response
    {
        session_start();

        $dateRDV = "". $_GET['date'] . "";

        $db = $this->getDoctrine()->getManager();
            $query = "UPDATE render_vous SET status = 'Annule' WHERE medecin_id = :medecin AND date_rdv = :dateRdv ";
            $stmt = $db->getConnection()->prepare($query);
            $params = array(
                            'medecin'=>$_GET['medecin'],
                            'dateRdv'=>$dateRDV
                        );
         
            $stmt->execute($params);

            $rdvPatient = $connection->fetchAll('SELECT * FROM render_vous, medecin WHERE id_patient = '. $_SESSION['id_patient'] .' AND render_vous.medecin_id = medecin.id');

        if (empty($rdvPatient)) {
            $rdvPatient[0]['medecin_id'] = null;
            $rdvPatient[0]['date_rdv'] = null;
            $rdvPatient[0]['id_patient'] = null;
        }
        
        return $this->render('consultationrdv/index.html.twig', [
            'controller_name' => 'ConsultationrdvController',
            'rendez' => $rdvPatient,
            'session' => $_SESSION
        ]);
    }
}
