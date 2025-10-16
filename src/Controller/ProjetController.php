<?php

namespace App\Controller;

use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/api/projet/{id}', name: 'app_projet')]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        if (null === $projet) {
            throw new NotFoundHttpException(
                'Projet with id ' . $id . ' not found'
            );
        }
        return $this->json(['projet' => $projet->getDescription()]);
    }
}
