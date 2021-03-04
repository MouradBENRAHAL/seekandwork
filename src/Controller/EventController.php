<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\EventDataCollector;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/affiche", name="list_event")
     */
    public function afficherevent()
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->findAll();


        return $this->render('event/frontshowevent.html.twig', [
            "event" => $event,
        ]);
    }
    /**
     * @Route("/event/add_event", name="add_event")
     */
    public function addEvenement(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class,$event);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($event);

            $entityManager->flush();

            return $this->redirectToRoute('list_event');

        }

        return $this->render("event/add.html.twig", [
            "form_title" => "Ajouter un evenement",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/delete_event/{id}", name="delete_event")
     */
    public function deleteEvent(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->find($id);
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('list_event');
    }

    /**
     * @Route("/event/edit_event/{id}", name="edit_event")
     */
    public function editEvenet(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $event = $entityManager->getRepository(Event::class)->find($id);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('list_event');
        }

        return $this->render("event/editevent.html.twig", [
            "form_title" => "Modifier un evenement",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/list_eventfront", name="list_eventfront")
     */
    public function listEventfront( )
    {
        $event = $this->getDoctrine()->getRepository(Event::class)->findAll();


        return $this->render('frontend/listevent.html.twig', [
            "event" => $event,
        ]);
    }





}
