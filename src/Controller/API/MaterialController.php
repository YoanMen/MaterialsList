<?php

namespace App\Controller\API;

use App\Service\MaterialService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialController extends AbstractController
{
    public function __construct(private MaterialService $materialService)
    {
    }

    #[Route('api/material', methods: ['POST'], name: 'api.getMaterials')]
    public function index(Request $request): Response
    {
        $draw = $request->get('draw', 1);
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $search = $request->get('search', ['value' => '']);
        $order = $request->get('order', []);

        $materials = $this->materialService->getMaterials($start, $length, $search['value'], $order);

        return $this->json([
            'draw' => $draw,
            'recordsTotal' => $materials['maxResult'],
            'recordsFiltered' => $materials['maxResult'],
            'data' => $materials['data'],
        ]);
    }

    #[Route('/material/{id}/decrement', methods: ['POST'], name: 'api.decrementMaterials')]
    public function decrement(int $id): Response
    {
        try {
            $this->materialService->decrementMaterial($id);

            return $this->json([], 200);
        } catch (\Throwable $th) {
            return $this->json(['error' => $th], 500);
        }
    }
}
