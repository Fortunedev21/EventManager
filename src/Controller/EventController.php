<?php

namespace App\Controller;

use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use Symfony\Component\Routing\Annotation\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    /*private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }*/

    /**
     * @Route("/create-event", name="create_event")
     */
    #[Route(path: '/create-event', name: 'create_event', methods: ['GET', 'POST'])]
    public function createEvent(Request $request, EventRepository $eventRepository): Response
    {

        // Créer une nouvelle instance d'entité Event
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $eventRepository->saveEvent($event);

            $this->addFlash('success', 'Votre évènement a été crée avec succès');

            return $this->redirectToRoute('event');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update-event/{id}", name="update_event")
     */
    #[Route('/update-event/{id}', name: 'update_event', methods: ['GET', 'POST'])]
    public function updateEvent(Request $request, int $id, EntityManagerInterface $entityManager)
    {
        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            $this->addFlash('error', 'Cet évènement n\'existe pas');
        }else{
            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                // Aucun besoin de EventRepository ici, utilisez directement l'EntityManager
                $entityManager->persist($event);
                $entityManager->flush();
    
                $this->addFlash('success', 'Votre événement a été modifié avec succès');
                return $this->redirectToRoute('event');
            }
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove-event/{id}", name="remove_event")
     * @ParamConverter("event", class="App\Entity\Event")
     */
    #[Route(path: '/remove-event/{id}', name: 'remove_event')]
    #[ParamConverter('event', class: 'App\Entity\Event')]
    public function removeEvent(Event $event): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        return $this->redirectToRoute('event');
    }


    /**
     * @Route("/event", name="event")
     */
    #[Route(path: '/event', name: 'event')]
    public function showEvents(EventRepository $eventRepository): response
    {
        $events = $eventRepository->findAll();
        //dd($events);

        return $this->render('event/event.html.twig', [
            'events' => $events,
        ]);
    }
}
