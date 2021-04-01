<?php

namespace App\Controller;

use App\Entity\Entretien;
use App\Form\EntretienType;
use App\Repository\EntretienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entretien")
 */
class EntretienController extends AbstractController
{
    /**
     * @Route("/", name="entretien_index", methods={"GET"})
     */
    public function index(): Response
    {
        $entretiens = $this->getDoctrine()
            ->getRepository(Entretien::class)
            ->findAll();

        return $this->render('entretien/index.html.twig', [
            'entretiens' => $entretiens,
        ]);
    }

    /**
     * @Route("/new", name="entretien_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entretien = new Entretien();
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cv =$form->get('cv')->getData();
            $nomcv = md5(uniqid()).'.'.$cv->guessExtension();
            $cv->move($this->getParameter('upload_directory'),$nomcv);
            $entretien->setCv($nomcv);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entretien);
            $entityManager->flush();

            return $this->redirectToRoute('entretien_index');
        }

        return $this->render('entretien/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show", name="entretien_show", methods={"GET"})
     */
    public function show(Entretien $entretien): Response
    {
        return $this->render('entretien/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entretien_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entretien $entretien): Response
    {
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entretien_index');
        }

        return $this->render('entretien/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="entretien_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entretien $entretien): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entretien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entretien_index');
    }

    /**
     * @Route("/calendrier_entretien",name="calendrier", methods={"GET"})
     */
    public function calendrier(): Response
    {
        $entretiens = $this->getDoctrine()->getRepository(Entretien::class)->findAll();
         $rdv =[];
         foreach ( $entretiens as $entretiens) {
             $rdv[] =[
             'title' => $entretiens->getTitle(),
             'start' => $entretiens->getBegin()->format('Y-m-d H:i:s'),
             'end'   => $entretiens->getend()->format('Y-m-d H:i:s'),
             'backgroundColor' => 'aquamarine'
             ];
         }
        $data= json_encode($rdv);
        return $this->render('entretien/calendrier.html.twig',compact('data'));
    }


    /**
     * @Route("/searchOffreajax ", name="ajaxsearch")
     */
    public function searchOffreajax(Request $request,EntretienRepository $repository)
    {
        $repository = $this->getDoctrine()->getRepository(Entretien::class);
        $requestString=$request->get('searchValue');
        $entretiens = $repository->findentretienbydate($requestString);
        return $this->render('entretien/entretienajax.html.twig', [
            "entretiens"=>$entretiens
        ]);
    }


}
