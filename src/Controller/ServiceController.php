<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceModifType;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\DoctrineExtensions;


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
        /*,[
            'include_published_at'=>true
        ]);*/
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();


             /*  $file=$service->getRapport();
            if ($file){
            $fileName=$this->generateUniqueFileName()'.'.$file->guessExtension();
            //dd($fileName);
            $file->move($this->getParameter('uploads_directory'),$fileName);
                //dd($fileName);
            $service->setRapport($fileName);
            //dd($service);
            }
             */
        /*
            $RapportFile = $form->get('rapport')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($RapportFile) {
                $originalFilename = pathinfo($RapportFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$RapportFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $RapportFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $service->setRapport($newFilename);
            }
        */
            // ... persist the $product variable or any other work



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
        $form = $this->createForm(ServiceModifType::class, $service);
        /*,[
            'include_published_at'=>true
        ]);*/
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


          // /**var UploadedFile $uploadedfile */
           /* $uploadedFile=$form['rapportNom']->getData();
            $destination=$this->getParameter('kernel.project_dir').'/public/uploads/rapports';
            $originalFilename= pathinfo($uploadedFile->getClientOriginalName(),PATHINFO_FILENAME);
            $newFilename=md5($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension;
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $service->setRapport($newFilename);*/
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
