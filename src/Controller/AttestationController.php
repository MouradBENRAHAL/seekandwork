<?php

namespace App\Controller;

use App\Entity\Attestation;
use App\Form\AttestationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attestation")
 */
class AttestationController extends AbstractController
{
    /**
     * @Route("/", name="attestation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $attestations = $this->getDoctrine()
            ->getRepository(Attestation::class)
            ->findAll();

        return $this->render('attestation/afficher_attestation.html.twig', [
            'attestations' => $attestations,
        ]);
    }

    /**
     * @Route("/new", name="attestation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attestation = new Attestation();
        $attestation->setDate(new \DateTime('now')); //Afficher la date actuelle
        $form = $this->createForm(AttestationType::class, $attestation);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attestation);
            $entityManager->flush();

            return $this->redirectToRoute('attestation_index');
        }

        return $this->render('attestation/new_attestation.html.twig', [
            'attestation' => $attestation,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="attestation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Attestation $attestation): Response
    {
        $form = $this->createForm(AttestationType::class, $attestation);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attestation_index');
        }

        return $this->render('attestation/edit_attestation.html.twig', [
            'attestation' => $attestation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("del/{id}", name="attestation_delete")
     */
    public function delete($id): Response
    {
        $reclamation = $this->getDoctrine()->getRepository(Attestation::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reclamation);
        $entityManager->flush();

        return $this->redirectToRoute('attestation_index');
    }


}
