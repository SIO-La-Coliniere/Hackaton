<?php

namespace App\Controller;

use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class InscriptionController extends AbstractController
{
    #[Route('/api/inscription/{id}', name: 'app_inscription')]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $inscription = $entityManager->getRepository(Inscription::class)->find($id);
        if (null === $inscription) {
            throw new NotFoundHttpException(
                'Inscription with id ' . $id . ' not found'
            );
        }
        return $this->json(['inscription' => $inscription->getCompetence()]);
    }
}
