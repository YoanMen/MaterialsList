<?php

namespace App\Controller;

use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Service\MaterialService;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialController extends AbstractController
{
    public function __construct(private MaterialRepository $repository, private MaterialService $service)
    {
    }

    #[Route('/', name: 'app.material')]
    public function index(): Response
    {
        return $this->render('material/index.html.twig');
    }

    #[Route('/material/{id}', methods: ['POST', 'GET'], name: 'app.material.edit')]
    public function edit(int $id, Request $request): RedirectResponse|Response
    {
        $material = $this->repository->find($id);

        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->saveMaterial($material);

            $this->addFlash('success', message: 'Le matériel '.$material->getName().' a bien été modifier');

            return $this->redirectToRoute('app.material');
        }

        return $this->render('material/edit.html.twig', [
            'form' => $form,
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
