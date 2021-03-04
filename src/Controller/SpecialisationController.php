<?php

namespace App\Controller;

use App\Entity\Specialisation;
use App\Form\SpecialisationType;
//use http\Env\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SpecialisationRepository;

class SpecialisationController extends AbstractController
{
    /**
     * @Route("/specialisation", name="specialisation")
     */
    public function index(): Response
    {
        return $this->render('specialisation/index.html.twig', [
            'controller_name' => 'SpecialisationController',
        ]);
    }
    /**
    * @Route("/affichespecialisation", name="list_specialite")
     */
    public function afficherspecialite()
    {
        $specialisation = $this->getDoctrine()->getRepository(Specialisation::class)->findAll();


        return $this->render('specialisation/frontshowspecialisation.html.twig', [
            "specialisation" => $specialisation,
        ]);
    }

    /**
     * @Route("/specialisation/add_specialisation", name="add_specialisation")
     */
    public function addSpecialisation(Request $request): Response
    {
        $specialisation = new Specialisation();
        $form = $this->createForm(SpecialisationType::class,$specialisation);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($specialisation);

            $entityManager->flush();

            return $this->redirectToRoute('list_specialite');

        }

        return $this->render("specialisation/addspecialisation.html.twig", [
            "form_title" => "Ajouter une specialite",
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/specialisation/delete_specialisation/{id}", name="delete_specialisation")
     */
    public function deleteSpecialisation(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $specialisation = $entityManager->getRepository(Specialisation::class)->find($id);
        $entityManager->remove($specialisation);
        $entityManager->flush();
        return $this->redirectToRoute('list_specialite');
    }

    /**
     * @Route("/specialisation/edit_specialisation/{id}", name="edit_specialisation")
     */
    public function editSpecialisation(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $specialisation = $entityManager->getRepository(Specialisation::class)->find($id);
        $form = $this->createForm(SpecialisationType::class, $specialisation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('list_specialite');
        }

        return $this->render("specialisation/editspecialisation.html.twig", [
            "form_title" => "Modifier une specialite",
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/list_specialisationfront/{idevent}", name="list_specialisationfront")
     */
    public function listSpecialitefront($idevent)
    {
        $specialisation = $this->getDoctrine()->getRepository(Specialisation::class)->findByEvent($idevent);
        return $this->render('frontend/listspecialite.html.twig', [
            "specialisation" => $specialisation,]);

    }





}
