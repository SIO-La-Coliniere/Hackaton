<?php

namespace App\Controller;

use App\Entity\Hackathon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class HackathonController extends AbstractController
{
    #[Route('/api/hackathon/{id}', name: 'app_hackathon')]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $hackathon = $entityManager->getRepository(Hackathon::class)->find($id);
        if (null === $hackathon) {
            throw new NotFoundHttpException(
                'Hackathon with id ' . $id . ' not found'
            );
        }
        return $this->json(['hackathon' => $hackathon->getLieu()]);
    }
}
