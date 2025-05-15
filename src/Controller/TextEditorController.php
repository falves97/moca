<?php

namespace App\Controller;

use App\Entity\ImageFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

#[Route('/text_editor', name: 'app_text_editor_')]
final class TextEditorController extends AbstractController
{
    #[Route('/upload', name: 'upload', methods: ['POST'])]
    public function upload(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        try {
            $image = new ImageFile();
            $image->setFile($request->files->get('file'));

            $entityManager->persist($image);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            'location' => $uploaderHelper->asset($image),
        ], Response::HTTP_OK);
    }
}
