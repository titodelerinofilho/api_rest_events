<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Lecture;
use App\Entity\Event;

    
    /**
     * @Route("/lecture", name="lecture_")
     */
class LectureController extends AbstractController
{
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $lectures = $entityManager->getRepository(Lecture::class)->findAllWithEventId();

        if($lectures == NULL) {
            return new JsonResponse(['lecture' => 'Não há palestras!']);
        } else {
    
            $data = [];
            foreach ((array) $lectures as $lecture) {

                //$event_id = $lecture->getEventId();
                //$event_relate = $entityManager->getRepository(Event::class)->find($event_id);
                $event_name = $lecture->getEventId()->getTitle();

                $data[] = [
                    'id' => $lecture->getId(),
                    'title' => $lecture->getTitle(),
                    'event_id' => $lecture->getEventId(),
                    'event_name' => $event_name,
                    'date' => $lecture->getDate(),
                    'time_start' => $lecture->getTimeStart(),
                    'time_end' => $lecture->getTimeEnd(),
                    'description' => $lecture->getDescription(),
                    'speaker' => $lecture->getSpeaker(),
                    'created_at' => $lecture->getCreatedAt(),
                    'updated_at' => $lecture->getUpdatedAt()
                    ];
            }
            return new JsonResponse(['lecture' => $data]);
        }
    }

    #[Route('/{LectureId}', name: 'showOnlyLecture', methods: 'GET')]
    public function showOnly(ManagerRegistry $doctrine, $LectureId): Response
    {
        $entityManager = $doctrine->getManager();
        $lectures = $entityManager->getRepository(Lecture::class)->find($LectureId);

        if($lectures == NULL) {
            return new JsonResponse(['lecture' => 'Não há palestras com o ID '. $LectureId ]);
        }

        $eventId = $lectures->getEventId();
        if($eventId == NULL) {
            return new JsonResponse(['lecture' => 'Não há eventos atrelados a essa palestra']);
        }

        $data = [
            'id' => $lectures->getId(),
            'title' => $lectures->getTitle(),
            'date' => $lectures->getDate(),
            'event_id' => $lectures->getEventId(),
            'time_start' => $lectures->getTimeStart(),
            'time_end' => $lectures->getTimeEnd(),
            'description' => $lectures->getDescription(),
            'speaker' => $lectures->getSpeaker(),
            'created_at' => $lectures->getCreatedAt(),
            'updated_at' => $lectures->getUpdatedAt()
        ];

            return new JsonResponse($data);
    }

    #[Route('/', name: 'create', methods: 'POST')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $data = $request->request->all();
        $entityManager = $doctrine->getManager();
        
        $lectures = new Lecture();

        $event = $entityManager->getRepository(Event::class)->find($data['event_id']);

        if($event == NULL) {
            return new JsonResponse(['event' => 'Não há eventos com o ID informado!']);
        }

        $nameEvent = $event->getTitle();

        $lectures->setTitle($data['title']);
        $lectures->setDate(new \DateTime($data['date'], new \DateTimezone('America/Sao_Paulo')));
        $lectures->setEventId($event);
        $lectures->setTimeStart(new \DateTime($data['time_start'], new \DateTimezone('America/Sao_Paulo')));
        $lectures->setTimeEnd(new \DateTime($data['time_end'], new \DateTimezone('America/Sao_Paulo')));
        $lectures->setDescription($data['description']);
        $lectures->setSpeaker($data['speaker']);
        $lectures->setCreatedAt(new \DateTime('now', new \DateTimezone('America/Sao_Paulo')));
        $lectures->setUpdatedAt(new \DateTime('now', new \DateTimezone('America/Sao_Paulo')));

        $entityManager->persist($lectures);
        $entityManager->flush();

        return new JsonResponse([
            'lecture' => 'Palestra criada com sucesso',
            'event' => 'Palestra criada para o evento '.$nameEvent
        ]);
    }

    #[Route('/{LectureId}', name: 'update', methods: 'PUT|PATCH')]
    public function update(ManagerRegistry $doctrine, Request $request, $LectureId): Response
    {
        $entityManager = $doctrine->getManager();
        $data = $request->request->all();

        $lecture = $entityManager->getRepository(Lecture::class)->find($LectureId);
        $event = $entityManager->getRepository(Event::class)->find($data['event_id']);

        $lecture->setTitle($data['title']);
        $lecture->setDate(new \DateTime($data['date'], new \DateTimezone('America/Sao_Paulo')));
        $lecture->setEventId($event);
        $lecture->setTimeStart(new \DateTime($data['time_start'], new \DateTimezone('America/Sao_Paulo')));
        $lecture->setTimeEnd(new \DateTime($data['time_end'], new \DateTimezone('America/Sao_Paulo')));
        $lecture->setDescription($data['description']);
        $lecture->setSpeaker($data['speaker']);
        $lecture->setUpdatedAt(new \DateTime('now', new \DateTimezone('America/Sao_Paulo')));

        $entityManager->flush();

        return new JsonResponse(['lecture' => 'Palestra de ID '.$LectureId.' atualizado com sucesso!']);
    }

    #[Route('/{LectureId}', name: 'delete', methods: 'DELETE')]
    public function delete(ManagerRegistry $doctrine, $LectureId): Response
    {
        $entityManager = $doctrine->getManager();

        $lecture = $entityManager->getRepository(Lecture::class)->find($LectureId);

        $remove = $entityManager->remove($lecture);
        $entityManager->flush();

        return new JsonResponse(['lecture' => 'Palestra de ID '.$LectureId.' REMOVIDO com sucesso!']);
    }
}
