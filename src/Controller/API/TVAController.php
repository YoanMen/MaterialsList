<?php

namespace App\Controller\API;

use App\Repository\TVARepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TVAController extends AbstractController
{
    #[Route('api/tva/{id}', methods: ['GET'], name: 'api.getTVA')]
    public function index(int $id, TVARepository $repository): Response
    {
        try {
            $tva = $repository->find($id);

            return $this->json(['success' => true, 'data' => $tva->getValue()], 200);
        } catch (\Throwable $th) {
            return $this->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
    }
}
