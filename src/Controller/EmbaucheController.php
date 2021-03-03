<?php

namespace App\Controller;

use App\Entity\Embauche;
use App\Form\EmbaucheType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/embauche")
 */
class EmbaucheController extends AbstractController
{
    /**
     * @Route("/", name="embauche_index", methods={"GET"})
     */
    public function index(): Response
    {
        $embauches = $this->getDoctrine()
            ->getRepository(Embauche::class)
            ->findAll();

        return $this->render('embauche/index.html.twig', [
            'embauches' => $embauches,
        ]);
    }

    /**
     * @Route("/new", name="embauche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $embauche = new Embauche();
        $form = $this->createForm(EmbaucheType::class, $embauche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($embauche);
            $entityManager->flush();

            return $this->redirectToRoute('embauche_index');
        }

        return $this->render('embauche/new.html.twig', [
            'embauche' => $embauche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="embauche_show", methods={"GET"})
     */
    public function show(Embauche $embauche): Response
    {
        return $this->render('embauche/show.html.twig', [
            'embauche' => $embauche,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="embauche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Embauche $embauche): Response
    {
        $form = $this->createForm(EmbaucheType::class, $embauche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('embauche_index');
        }

        return $this->render('embauche/edit.html.twig', [
            'embauche' => $embauche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="embauche_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Embauche $embauche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$embauche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($embauche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('embauche_index');
    }
}
