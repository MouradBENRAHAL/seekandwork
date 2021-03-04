<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/addC" , name="add_commentaire")
     */
    function Add(Request $request)
    {
        $commentaire=new Commentaire();
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('affiche_commentaire');
        }
        return $this->render('commentaire/add.html.twig',[
            'commentaire' => $commentaire,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route ("/afficheC" , name="affiche_commentaire")
     */
    public function Affiche()
    {
        $repo=$this->getDoctrine()->getRepository(Commentaire::class);
        $commentaire=$repo->findAll();
        return $this->render('commentaire/affiche.html.twig',
            ['commentaire'=>$commentaire]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route ("/deleteC/{id}" , name="delete_commentaire")
     */
    public function delete(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $forum= $em->getRepository(Commentaire::class)->find($id);
        $em->remove($forum);
        $em->flush();
        return $this->redirectToRoute('affiche_commentaire');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route ("/updateC/{id}" , name="update_commentaire")
     */
    public function edit(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $blog = $entityManager->getRepository(Commentaire::class)->find($id);
        $form = $this->createForm(CommentaireType::class, $blog);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('affiche_commentaire');
        }

        return $this->render("commentaire/edit.html.twig", [
            "form_title" => "Modifier un commentaire",
            "form" => $form->createView(),
        ]);
    }
}
