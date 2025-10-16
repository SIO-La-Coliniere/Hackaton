<?php

namespace App\Controller;

use App\Entity\Organisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class OrganisateurController extends AbstractController
{
    #[Route('/api/organisateur/{id}', name: 'app_organisateur')]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $organisateur = $entityManager->getRepository(Organisateur::class)->find($id);
        if (null === $organisateur) {
            throw new NotFoundHttpException(
                'Organisateur with id ' . $id . ' not found'
            );
        }
        return $this->json(['organisateur' => $organisateur->getEmail()]);
    }
}
