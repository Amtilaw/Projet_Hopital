<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModificationinfopatientController extends AbstractController
{
    /**
     * @Route("/modificationinfopatient", name="modificationinfopatient")
     */
    public function index(): Response
    {
        return $this->render('modificationinfopatient/index.html.twig', [
            'controller_name' => 'ModificationinfopatientController',
        ]);
    }
}
