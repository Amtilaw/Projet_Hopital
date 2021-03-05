<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConnexionpatientController extends AbstractController
{
    /**
     * @Route("/connexionpatient", name="connexionpatient")
     */
    public function index(Request $request, Connection $connection): Response
    {

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
            $passwd = $_POST['passwd'];

        $connexion = $connection->fetchAll('SELECT * FROM patientConnexion WHERE email = "'. $email .'"');

        if (!empty($connexion)){
            if (password_verify($passwd,$connexion[0]['passwd'])){
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['type_user'] = "patient";
                $_SESSION['name'] = $connexion[0]['nom'];
                $_SESSION['id_patient'] = $connexion[0]['id'];
                return $this->redirectToRoute('accueilconnexcion');
            }
        }

        }
        return $this->render('connexionpatient/index.html.twig', [
            'controller_name' => 'ConnexionpatientController',
        ]);
    }
}
