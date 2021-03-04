<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/service")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="service_index", methods={"GET"})
     */
    public function index(): Response
    {
        $services = $this->getDoctrine()
            ->getRepository(Service::class)
            ->findAll();

        return $this->render('service/afficher_service.html.twig', [
            'services' => $services,
        ]);
    }
    /**
     * @Route("/admin", name="service_index_admin", methods={"GET"})
     */
    public function indexServiceAdmin(): Response
    {
        $services = $this->getDoctrine()
            ->getRepository(Service::class)
            ->findAll();

        return $this->render('service/afficher_service_admin.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/new", name="service_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $service = new Service();
        $service->setRdv(new \DateTime('now'));
        $form = $this->createForm(ServiceType::class, $service);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();


            $file=$service->getRapport();
            if ($file){
            $fileName=md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads_directory'),$fileName);
            $service->setRapport($fileName);
            }


            return $this->redirectToRoute('service_index');
        }

        return $this->render('service/new_service.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="service_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_index');
        }

        return $this->render('service/edit_service.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="service_delete")
     */
    public function delete($id): Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($service);
        $entityManager->flush();

        return $this->redirectToRoute('service_index');
    }

    /**
     * @Route("/admin/{id}", name="service_delete_admin")
     */
    public function deleteServiceAdmin($id): Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($service);
        $entityManager->flush();

        return $this->redirectToRoute('service_index_admin');
    }
}
