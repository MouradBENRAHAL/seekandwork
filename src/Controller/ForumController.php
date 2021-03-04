<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(): Response
    {
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/addF" , name="add_forum")
     */
    function Add(Request $request)
    {
        $forum=new Forum();
        $form=$this->createForm(ForumType::class,$forum);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('affiche_forum');
        }
        return $this->render('forum/add.html.twig',[
            'forum' => $forum,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route ("/afficheF" , name="affiche_forum")
     */
    public function AfficheForum()
    {
        $repo=$this->getDoctrine()->getRepository(Forum::class);
        $forum=$repo->findAll();
        return $this->render('forum/Affiche.html.twig',
            ['forum'=>$forum]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route ("/deleteF/{id}" , name="delete_forum")
     */
    public function deleteForum(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $forum= $em->getRepository(Forum::class)->find($id);
        $em->remove($forum);
        $em->flush();
        return $this->redirectToRoute('affiche_forum');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route ("/updateF/{id}" , name="update_forum")
     */
    public function edit(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $blog = $entityManager->getRepository(Forum::class)->find($id);
        $form = $this->createForm(ForumType::class, $blog);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('affiche_forum');
        }

        return $this->render("forum/edit.html.twig", [
            "form_title" => "Modifier un forum",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route ("/afficheF_front" , name="affiche_forum_front")
     */
    public function AfficheForumFront()
    {
        $repo=$this->getDoctrine()->getRepository(Forum::class);
        $forum=$repo->findAll();
        return $this->render('forum/Affichefront.html.twig',
            ['forum'=>$forum]);
    }
}
