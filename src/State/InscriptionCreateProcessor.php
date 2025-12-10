<?php
namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Hackathon;
use App\Entity\Inscription;
use App\Entity\Participant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

final class InscriptionCreateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Inscription
    {
        if (!$data instanceof Inscription) {
            throw new \LogicException('InscriptionCreateProcessor attend une entité Inscription.');
        }

        // 1) Auth obligatoire
        $user = $this->security->getUser();
        if (!$user) {
            throw new AccessDeniedHttpException('Authentification requise.');
        }

        // 2) Hackathon obligatoire
        $hackathon = $data->getHackathon();
        if (!$hackathon instanceof Hackathon) {
            throw new BadRequestHttpException('Champ "hackathon" manquant.');
        }

        // 3) Trouver (ou créer) le Participant lié à l’utilisateur
        /** @var \Symfony\Component\Security\Core\User\UserInterface $user */
        $email = method_exists($user, 'getUserIdentifier') ? $user->getUserIdentifier() : $user->getUsername();

        $participantRepo = $this->em->getRepository(Participant::class);
        $participant = $participantRepo->findOneBy(['email' => $email]);

        if (!$participant) {
            // ⚠️ Si ta table Participant a des NOT NULL (nom, prenom, telephone, date_naissance…),
            // mets des valeurs par défaut raisonnables ici.
            $participant = (new Participant())
                ->setEmail($email)
                ->setNom('Inconnu')
                ->setPrenom('Inconnu')
                ->setTelephone('0000000000')
                ->setDateNaissance(new \DateTimeImmutable('2000-01-01'));
            $this->em->persist($participant);
        }

        // 4) Anti double-inscription
        $inscriptionRepo = $this->em->getRepository(Inscription::class);
        $already = $inscriptionRepo->findOneBy([
            'hackathon'   => $hackathon,
            'participant' => $participant,
        ]);
        if ($already) {
            throw new ConflictHttpException('Vous êtes déjà inscrit à ce hackathon.');
        }

        // 5) Hydrate l’inscription
        $data->setParticipant($participant);
        if (!$data->getDate()) {
            $data->setDate(new \DateTimeImmutable());
        }

        // 6) Num séquentiel par hackathon (MAX(num) + 1) dans une petite transaction
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {
            $next = (int) $conn->fetchOne(
                    'SELECT COALESCE(MAX(num), 0) FROM inscription WHERE hackathon_id = :h',
                    ['h' => $hackathon->getId()]
                ) + 1;

            $data->setNum($next);

            $this->em->persist($data);
            $this->em->flush();
            $conn->commit();
        } catch (\Throwable $e) {
            $conn->rollBack();
            throw $e;
        }

        return $data;
    }
}
