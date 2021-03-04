<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserRepository;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @param UserRepository $repository
     * @return Response
     * @Route("/AfficheU" , name="affiche_user")
     */
    public function AfficheUser(\App\Repository\UserRepository $repository)
    {
        //$repo=$this->getDoctrine()->getRepository(User::class);
        $user=$repository->findAll();
        return $this->render('user/Affiche.html.twig',
        ['user'=>$user]);
    }

    /**
     * @Route("/deleteU/{id}", name="deleteU")
     */
    function Delete($id,\App\Repository\UserRepository $repository){
      $user=$repository->find($id);
      $em=$this->getDoctrine()->getManager();
      $em->remove($user);
      $em->flush();
      return $this->redirectToRoute('affiche_user');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/addU" , name="add_user")
     */
    function Add(Request $request)
    {
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('frontacceuil');
        }
        return $this->render('user/add.html.twig',[
            'user' => $user,
            'form'=>$form->createView()
        ]);
    }

}
