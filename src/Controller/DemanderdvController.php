<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;



class DemanderdvController extends AbstractController
{
    /**
     * @Route("/demanderdv", name="demanderdv")
     */
    public function index(Request $request, Connection $connection): Response
    {

        $alert = "";
        if (!empty($_POST['date'])) {

            $dateRdv = $_POST['date']; 
            $heures = $_POST['heure'];
            $medecin_nom = $_POST['medecin'];

            $times = $dateRdv . " " . $heures . ":00";

            $medecin_id = $connection->fetchAll('SELECT id FROM medecin WHERE nom = "'. $medecin_nom .'"');

            $time = strtotime($heures);
            $periodAvant = date("H:i", strtotime('-30 minutes', $time));
            $periodApres = date("H:i", strtotime('+30 minutes', $time));

            $rdvNonDispoAvant = $dateRdv . " " .$periodAvant . ":00";
            $rdvNonDispoApres = $dateRdv . " " .$periodApres . ":00";
            $rdvMedecin = $connection->fetchAll('SELECT * FROM render_vous WHERE date_rdv > "'. $rdvNonDispoAvant .'" AND date_rdv < "'. $rdvNonDispoApres .'"');
            
            if (empty($rdvMedecin)) {
           
                $db = $this->getDoctrine()->getManager();
                $query = "INSERT INTO render_vous (medecin_id,date_rdv,id_patient,status) 
                        VALUE (:id_medecin, :dateRdv, :id_patient, :status)";
                $stmt = $db->getConnection()->prepare($query);
                $params = array(
                                'id_medecin'=>$medecin_id[0]['id'],
                                'dateRdv'=>$times,
                                'id_patient'=>$_SESSION['id_patient'],
                                'status'=> "Demande"
                            );
            
                $stmt->execute($params);

                return $this->redirectToRoute('accueilconnexcion');
            }
            else {
                $alert = "Le medecin n'est pas disponible durant l'heure de rendez-vous choisie, veuiller changer l'heure de rendez-vous.";
            }

        }

        if (empty($_POST['date'])){
        session_start();
        }

        $medecins = $connection->fetchAll('SELECT * FROM medecin');



        return $this->render('demanderdv/index.html.twig', [
            'controller_name' => 'DemanderdvController',
            'medecins' => $medecins,
            'session' => $_SESSION,
            'alert' => $alert
        ]);
    }
}
