<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Reduction;
use App\Form\ReductionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReductionController extends AbstractController
{
    /**
     * @Route("/red /add_red", name="add_reduction")
     */
    public function addreduction(Request $request): Response
    {
        $formation = new Reduction();
        $form = $this->createForm(ReductionType::class,$formation);
        $form->handleRequest($request);


        if($form->isSubmitted()&& $form->isValid())
        {

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($formation);

            $entityManager->flush();

            return $this->redirectToRoute('liste_reduction');

        }

        return $this->render("reduction/addreduction.html.twig", [
            "form_title" => "Ajouter un formation",
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/reduction/liste_reduction", name="liste_reduction")
     */
    public function listeReduction(Request $request)
    {
        $reduction = $this->getDoctrine()->getRepository(Reduction::class)->findAll();


        return $this->render('reduction/showreduction.html.twig', [
            "reduction" => $reduction,
        ]);
    }

    /**
     * @Route("/reduction/detail_reduction/{id}", name="detail_reduction")

     */
    public function DetailReduction(Request $request, $id, $reduction):Response
    {
        $formation = $this->getDoctrine()->getRepository(Reduction::class)->find($id);


        return $this->render('formation/detailreduction.html.twig', [
            "r" => $reduction,
        ]);
    }

    /**
     * @Route("/reduction/delete_reduction/{id}", name="delete_reduction")
     */
    public function deleteReduction(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $reduction = $entityManager->getRepository(Reduction::class)->find($id);
        $entityManager->remove($reduction);
        $entityManager->flush();
        return $this->redirectToRoute('liste_reduction');
    }
    /**
     * @Route("/reduction/edit_reduction/{id}", name="edit_reduction")
     */
    public function editReduction(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $reduction = $entityManager->getRepository(Reduction::class)->find($id);
        $form = $this->createForm(ReductionType::class, $reduction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('liste_reduction');
        }

        return $this->render("reduction/editreduction.html.twig", [
            "form_title" => "Modifier une reduction",
            "form" => $form->createView(),
        ]);
    }


}
