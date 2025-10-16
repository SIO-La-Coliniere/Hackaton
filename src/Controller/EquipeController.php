<?php

namespace App\Controller;

use App\Entity\Equipe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class EquipeController extends AbstractController
{
    #[Route('/api/equipe/{id}', name: 'app_equipe')]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $equipe = $entityManager->getRepository(Equipe::class)->find($id);
        if (null === $equipe) {
            throw new NotFoundHttpException(
                'Equipe with id ' . $id . ' not found'
            );
        }
        return $this->json([
            'Id'=> $equipe->getId(),
            'Nom' => $equipe->getNom(),
            'Lien Prototype' => $equipe->getLienPrototype()
        ]);
    }
}
