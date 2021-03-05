<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, Connection $connection): Response
    {

        if (!empty($_POST['nom'])) {
            $nom = $_POST['nom']; $prenom = $_POST['prenom']; $gsm = $_POST['gsm']; $adress = $_POST['adress']; 
            $date_naissance = $_POST['naissance'];
            $arrive = $date_naissance;
            $sex = $_POST['sex'];
            $email = $_POST['email'];
            $passwd = password_hash($_POST['passwd'], PASSWORD_DEFAULT);

           
            $db = $this->getDoctrine()->getManager();
            $query = "INSERT INTO patientConnexion (nom,prenom,adress,naissance,gsm,sex, passwd, email) 
                    VALUE (:nom, :prenom, :adress, :naissance, :gsm, :sex, :pass, :email)";
            $stmt = $db->getConnection()->prepare($query);
            $params = array(
                            'nom'=>$nom,
                            'prenom'=>$prenom,
                            'adress'=>$adress,
                            'naissance'=>$date_naissance,
                            'gsm'=>$gsm,
                            'sex'=>$sex,
                            'pass'=>$passwd,
                            'email'=>$email
                        );
         
            $stmt->execute($params);

            
                    
        }
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
}
