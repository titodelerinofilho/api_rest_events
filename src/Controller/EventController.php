<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Event;
use App\Entity\Lecture;

    /**
     * @Route("/event", name="event_")
     */

class EventController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $events = $entityManager->getRepository(Event::class)->findAll();

        if($events == NULL) {
            return new JsonResponse(['event' => 'Não há eventos!']);
        } 
        else 
        {
            $data = [];
            foreach ((array) $events as $event) {
                $data[] = [
                    'id' => $event->getId(),
                    'title' => $event->getTitle(),
                    'date_start' => $event->getDateStart(),
                    'date_end' => $event->getDateEnd(),
                    'date_start' => $event->getDateStart(),
                    'description' => $event->getDescription(),
                    'status' => $event->getStatus(),
                    'created_at' => $event->getCreatedAt(),
                    'updated_at' => $event->getUpdatedAt()
                    ];
            }
            return new JsonResponse(['event' => $data]);
        }
    }
    /**
     * @Route("/{EventId}", name="showOnly", methods={"GET"})
     */
    public function showOnly(ManagerRegistry $doctrine, $EventId)
    {
        $entityManager = $doctrine->getManager();
        $events = $entityManager->getRepository(Event::class)->find($EventId);

        if($events == NULL) {
            return new JsonResponse(['event' => 'Não há eventos com o ID '. $EventId ]);
        } else {

        $data = [
            'id' => $events->getId(),
            'title' => $events->getTitle(),
            'date_start' => $events->getDateStart(),
            'date_end' => $events->getDateEnd(),
            'date_start' => $events->getDateStart(),
            'description' => $events->getDescription(),
            'status' => $events->getStatus(),
            'created_at' => $events->getCreatedAt(),
            'updated_at' => $events->getUpdatedAt()
        ];

            return new JsonResponse($data);
        }
    }
    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(ManagerRegistry $doctrine, Request $request) 
    {
        $data = $request->request->all();
        $entityManager = $doctrine->getManager();

        $event = new Event();

        $event->setTitle($data['title']);
        $event->setDateStart(new \DateTime($data['date_start'], new \DateTimezone('America/Sao_Paulo')));
        $event->setDateEnd(new \DateTime($data['date_end'], new \DateTimezone('America/Sao_Paulo')));
        $event->setDescription($data['description']);
        $event->setStatus($data['status']);
        $event->setCreatedAt(new \DateTime('now', new \DateTimezone('America/Sao_Paulo')));
        $event->setUpdatedAt(new \DateTime('now', new \DateTimezone('America/Sao_Paulo')));

        $entityManager->persist($event);
        $entityManager->flush();

        return new JsonResponse(['event' => 'Evento criado com sucesso']);
    }
    /**
     * @Route("/{EventId}", name="update", methods={"PUT","PATCH"})
     */
    public function update(Request $request, ManagerRegistry $doctrine, $EventId) 
    {
        $entityManager = $doctrine->getManager();
        $data = $request->request->all();

        $event = $entityManager->getRepository(Event::class)->find($EventId);
        $event->setTitle($data['title']);
        $event->setDescription($data['description']);
        $event->setStatus($data['status']);
        $event->setUpdatedAt(new \DateTime('now', new \DateTimezone('America/Sao_Paulo')));
        $entityManager->flush();

       return new JsonResponse(['event' => 'Evento de ID '.$EventId.' atualizado com sucesso!']);
    }
     /**
     * @Route("/{EventId}", name="delete", methods={"DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, $EventId) 
    {
        $entityManager = $doctrine->getManager();

        $event = $entityManager->getRepository(Event::class)->find($EventId);
        $eventName = $event->getTitle();

        if($event == NULL) {
            return new JsonResponse(['event' => 'Não há eventos com esse ID cadastrado!']);
        }
        $lectures = $entityManager->getRepository(Lecture::class)->findByEventId($EventId);

        foreach ($lectures as $lecture) {
            $event->removeLecture($lecture);
        }

        $remove = $entityManager->remove($event);
        $entityManager->flush();

        return new JsonResponse(['event' => 'Evento ['.$eventName.'] e suas palestras REMOVIDAS com sucesso!']);
    }
}
