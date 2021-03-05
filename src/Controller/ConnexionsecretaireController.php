<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ConnexionsecretaireController extends AbstractController
{
    /**
     * @Route("/connexionsecretaire", name="connexionsecretaire")
     */
    public function index(Request $request, Connection $connection): Response
    {
        if (!empty($_POST['pseudo'])) {
            $pseudo = $_POST['pseudo'];
            $passwd = $_POST['passwd'];

        $connexion = $connection->fetchAll('SELECT passwd FROM secretaireConnexion WHERE pseudo = "'. $pseudo .'"');

        if (!empty($connexion)){
            if ($connexion[0]['passwd'] == $passwd){

                session_start();
                $_SESSION['type_user'] = "secretaire";
                $_SESSION['name'] = $pseudo;
                
                return $this->redirectToRoute('accueilconnexcionadm');
            }
        }

        }
        return $this->render('connexionsecretaire/index.html.twig', [
            'controller_name' => 'ConnexionsecretaireController',
        ]);
    }
}
