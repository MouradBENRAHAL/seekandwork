<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationModifType;
use App\Form\ReclamationType;
use App\Repository\reclamationRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reclamations = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();

        return $this->render('reclamation/afficher_rec.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     * @Route("/admin", name="reclamation_index_admin", methods={"GET"})
     */
    public function indexRecAdmin(FlashyNotifier $flashy): Response
    {

        $reclamations=$this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        return $this->render('reclamation/afficher_rec_admin.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    /**
     *  @Route("/admin/stat", name="reclamation_stat", methods={"GET"})
     */
    public function stat()
    {
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sqlAdmin2 = 'SELECT nom,COUNT(*) AS toBeUsed FROM reclamation,user WHERE user.id = iduser GROUP BY nom';
        $sqlNbUsers = 'SELECT COUNT(*) AS nbUsers FROM user';
        $stmtAdmin2 = $conn->prepare($sqlAdmin2);
        $stmtnbuser = $conn->prepare($sqlNbUsers);
        $stmtnbuser->execute();
        $stmtAdmin2->execute();
        $arrayAdmin2 = $stmtAdmin2->fetchAll();
        $nb_users=$stmtAdmin2->fetchAll();
        //NUMBER OF USERS
        $nbUsers = 0;
        foreach ($nb_users as $nb){
            $nbUsers += intval($nb['nbUsers']);
        }

        $data2 = array(['user','Nombre de Reclamations']);
        foreach ($arrayAdmin2 as $item){
            array_push($data2,[$item['nom'],intval($item['toBeUsed'])]);

        }
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($data2);
        $pieChart->getOptions()->setTitle('Pourcentages des reclamations pour chaque utilisateurs');
        $pieChart->getOptions()->setWidth(600);
        $pieChart->getOptions()->setHeight(400);
        return $this->render('reclamation/stat.html.twig',[
            "piechart"=>$pieChart,
            "nbUsers"=>$nb_users
        ]);
    }

    /**
     * @Route("/new", name="reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {


        $reclamation = new Reclamation();
        $reclamation->setDate(new \DateTime('now')); //Afficher la date actuelle
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            /*$update=new Update("http://127.0.0.1:8000/backacceuil","[]");
            $publisher($update);*/

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/new_rec.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/{id}/edit", name="reclamation_edit", methods={"POST"})
     */
    public function edit(Request $request, Reclamation $reclamation): Response
    {
        $form = $this->createForm(ReclamationModifType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_index');
        }

        return $this->render('reclamation/edit_rec.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("del/{id}", name="reclamation_delete")
     */
    public function delete($id): Response
    {
            $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index');
    }
    /**
     * @Route("del/admin/{id}", name="reclamation_delete_admin")
     */
    public function deleteRecAdmin($id): Response
    {
            $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_index_admin');
    }
    /**
    * @Route("/searchLast3rec", name="searchLast3rec")
    */
    public function searchLastReclamation(Request $request,reclamationRepository $repository): Response
    {

        $reclamation = $repository->SearchByLastDate();
        return $this->render('reclamation/last3reclamations.html.twig', [
            'reclamations' => $reclamation,
        ]);
    }


}
