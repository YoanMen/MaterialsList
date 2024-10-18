<?php

namespace App\Controller;

use App\Repository\MaterialRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialsListController extends AbstractController
{
    public function __construct(private MaterialRepository $repository)
    {
    }

    #[Route('/', name: 'app.materials_list')]
    public function index(): Response
    {
        return $this->render('materials_list/index.html.twig', [
            'controller_name' => 'MaterialsListController',
        ]);
    }

    #[Route('material/{id}/pdf', methods: ['GET'], name: 'app.pdfMaterial')]
    public function pdf(int $id, Pdf $knpSnappyPdf): PdfResponse
    {
        $material = $this->repository->find($id);

        $html = $this->renderView('pdf/pdf.html.twig', [
            'material' => $material,
        ]);

        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $material->getName());
        $filename = str_replace(' ', '-', $name);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($html),
            'export-'.$filename.'.pdf'
        );
    }
}
