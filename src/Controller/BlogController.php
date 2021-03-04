<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/addB" , name="add_blog")
     */
    function Add(Request $request)
    {
        $blog=new Blog();
        $form=$this->createForm(BlogType::class,$blog);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('affiche_blog');
        }
        return $this->render('blog/add.html.twig',[
            'blog' => $blog,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route ("/afficheB" , name="affiche_blog")
     */
    public function AfficheBlog()
    {
        $repo=$this->getDoctrine()->getRepository(Blog::class);
        $blog=$repo->findAll();
        return $this->render('blog/Affiche.html.twig',
            ['blog'=>$blog]);
    }

    /**
     * @param int $idBlog
     * @return Response
     * @Route ("/deleteB/{id}" , name="delete_blog")
     */
    public function deleteBlog(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $blog= $em->getRepository(Blog::class)->find($id);
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute('affiche_blog');
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route ("update_blog/{id}", name="update_blog")
     */
    public function edit(Request $request, int $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $blog = $entityManager->getRepository(Blog::class)->find($id);
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            return $this->redirectToRoute('affiche_blog');
        }

        return $this->render("blog/edit.html.twig", [
            "form_title" => "Modifier un blog",
            "form" => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route ("/afficheB_front" , name="affiche_blog_front")
     */
    public function AfficheBlogFront()
    {
        $repo=$this->getDoctrine()->getRepository(Blog::class);
        $blog=$repo->findAll();
        return $this->render('blog/Affichefront.html.twig',
            ['blog'=>$blog]);
    }
}
