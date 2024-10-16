<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialsListController extends AbstractController
{
    #[Route('/', name: 'app_materials_list')]
    public function index(): Response
    {
        return $this->render('materials_list/index.html.twig', [
            'controller_name' => 'MaterialsListController',
        ]);
    }
}
