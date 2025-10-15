<?php

namespace App\Controller;

use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class ParticipantController extends AbstractController
{
    #[Route('/participant/{id}', name: 'app_participant', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $participant = $entityManager->getRepository(Participant::class)->find($id);
        if (null === $participant) {
            throw new NotFoundHttpException(
                'Participant with id ' . $id . ' not found'
            );
        }
        return $this->json([
            'nom' => $participant->getNom(),
            'prenom' => $participant->getPrenom(),
            'email' => $participant->getEmail(),
            'telephone' => $participant->getTelephone(),
            'dateNaissance' => $participant->getDateNaissance(),
            'lienPortefolio' => $participant->getLienPortefolio(),]);
    }

    #[Route('/participant', name: 'app_participant_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom']) || !isset($data['prenom']) || !isset($data['email']) || !isset($data['telephone']) || !isset($data['dateNaissance']) || !isset($data['lienPortefolio'])) {
            return $this->json(['error' => 'Missing required fields'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $participant = new Participant();
        $participant->setNom($data['nom']);
        $participant->setPrenom($data['prenom']);
        $participant->setEmail($data['email']);
        $participant->setTelephone($data['telephone']);
        $participant->setDateNaissance(new \DateTime());
        $participant->setLienPortefolio($data['lienPortefolio']);

        $entityManager->persist($participant);
        $entityManager->flush();

        return $this->json([
            'message' => 'Participant created successfully',
            'id' => $participant->getId(),
            'nom' => $participant->getNom(),
            'prenom' => $participant->getPrenom(),
            'email' => $participant->getEmail(),
            'telephone' => $participant->getTelephone(),
            'dateNaissance' => $participant->getDateNaissance(),
            'lienPortefolio' => $participant->getLienPortefolio(),
        ], JsonResponse::HTTP_CREATED);
    }
    #[Route('/{id}', name: 'app_participant_update', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $participant = $entityManager->getRepository(Participant::class)->find($id);
        if (!$participant) {
            return $this->json(['message' => 'Participant not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        try {
            if (isset($data['nom'])) {
                $participant->setNom($data['nom']);
            }
            if (isset($data['prenom'])) {
                $participant->setPrenom($data['prenom']);
            }
            if (isset($data['email'])) {
                $participant->setEmail($data['email']);
            }
            if (isset($data['telephone'])) {
                $participant->setTelephone($data['telephone']);
            }
            if (isset($data['dateNaissance'])) {
                $participant->setDateNaissance(new \DateTime());
            }
            if (isset($data['lienPortefolio'])) {
                $participant->setLienPortefolio($data['lienPortefolio']);
            }

            $entityManager->flush();

            return $this->json(['message' => 'Participant updated successfully']);
        } catch (NotFoundHttpException $exception) {
            return $this->json(['error' => $exception->getMessage()], status: 400);
        }
    }
    #[Route('/participant/{id}', name: 'app_participant_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $participant = $entityManager->getRepository(Participant::class)->find($id);

        if (!$participant) {
            return $this->json(['error' => 'Participant not found'], 404);
        }

        $entityManager->remove($participant);
        $entityManager->flush();

        return $this->json(['message' => 'Participant deleted successfully']);
    }

}
