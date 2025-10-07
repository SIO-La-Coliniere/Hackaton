<?php

namespace App\Controller;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class ParticipantController extends AbstractController
{
    #[Route('/participant/{id}', name: 'app_participant')]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $participant = $entityManager->getRepository(Participant::class)->find($id);
        if (null === $participant) {
            throw new NotFoundHttpException(
                'Participant with id ' . $id . ' not found'
            );
        }
        return $this->json(['participant' => $participant->getEmail()]);
    }
}
