<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation/liste_formation", name="liste_formation")
     */
    public function listeFormation(Request $request)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->findAll();


        return $this->render('formation/Affichef.html.twig', [
            "formation" => $formation,
        ]);
    }
    /**
     * @Route("/formation/detail_formation/{id}", name="detail_formation")
     */
    public function DetailFormation(Request $request,$id)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);


        return $this->render('formation/detailformation.html.twig', [
            "f" => $formation,
        ]);
    }
    /**
     * @Route("/formation/add_formation", name="add_formation")
     */
    public function addFormation(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class,$formation);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($formation);

            $entityManager->flush();

            return $this->redirectToRoute('liste_formation');

        }

        return $this->render("formation/addformation.html.twig", [
            "form_title" => "Ajouter un formation",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/formation/delete_fomration/{id}", name="delete_formation")
     */
    public function deleteFormation(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $formation = $entityManager->getRepository(Formation::class)->find($id);
        $entityManager->remove($formation);
        $entityManager->flush();
        return $this->redirectToRoute('liste_formation');
    }
    /**
     * @Route("/formation/edit_formation/{id}", name="edit_formation")
     */
    public function editFormation(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $formation = $entityManager->getRepository(Formation::class)->find($id);
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('liste_formation');
        }

        return $this->render("formation/editformation.html.twig", [
            "form_title" => "Modifier une formation",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/formation/listformation", name="list_formationfront")
     */
    public function listformationfront(Request $request)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->findAll();

        return $this->render('formation/Afficherf.html.twig', [
            "formation" => $formation,
        ]);
    }
}
