<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AjoutpatientController extends AbstractController
{
    /**
     * @Route("/ajoutpatient", name="ajoutpatient")
     */
    public function index(Request $request, Connection $connection): Response
    {

        $numChambre = $_GET['numChambre'];
        $numService = $_GET['numService'];

        if (!empty($_POST['nom'])) {
            $nom = $_POST['nom']; $prenom = $_POST['prenom']; $gsm = $_POST['gsm']; $adress = $_POST['adress']; 
            $date_naissance = $_POST['naissance'];
            $arrive = $date_naissance;
            $sex = $_POST['sex'];
           
            $db = $this->getDoctrine()->getManager();
            $query = "INSERT INTO patient (nom,prenom,adress,naissance,gsm,arrive,sex) 
                    VALUE (:nom, :prenom, :adress, :naissance, :gsm, :arrive, :sex)";
            $stmt = $db->getConnection()->prepare($query);
            $params = array(
                            'nom'=>$nom,
                            'prenom'=>$prenom,
                            'adress'=>$adress,
                            'naissance'=>$date_naissance,
                            'gsm'=>$gsm,
                            'arrive'=>$arrive,
                            'sex'=>$sex
                        );
         
            $stmt->execute($params);

            $patient_id = $connection->fetchAll('SELECT id_patient FROM patient
            WHERE nom = "'. $nom .'" AND prenom = "'. $prenom .'" AND gsm = "'. $gsm .'" ');

            $db = $this->getDoctrine()->getManager();
            $query = "INSERT INTO lit (patient_id,chambre_id) 
                    VALUE (:patient_id, :chambre_id)";
            $stmt = $db->getConnection()->prepare($query);
            $params = array(
                            'patient_id'=>$patient_id[0]['id_patient'],
                            'chambre_id'=>$numChambre,
                        );
         
            $stmt->execute($params);

            return $this->redirectToRoute('chambre', ['numService' => $numService, 'numChambre' => $numChambre]);
            
                    
        }

        return $this->render('ajoutpatient/index.html.twig', [
            'controller_name' => 'AjoutpatientController',
            'numChambre'=> $numChambre,
            'numService' => $numService
            
        ]);

    }
}
