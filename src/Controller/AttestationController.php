<?php

namespace App\Controller;

use App\Entity\Attestation;
use App\Form\AttestationType;
use App\Form\AttestationModifType;
use App\Form\SendAttestationType;
use App\Repository\attestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Dompdf\Dompdf;
use Dompdf\Options;

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
     * @Route("/admin", name="attestation_index_admin", methods={"GET"})
     */
    public function indexAttestationAdmin(): Response
    {
        $attestations = $this->getDoctrine()
            ->getRepository(Attestation::class)
            ->findAll();

        return $this->render('attestation/afficher_attestation_admin.html.twig', [
            'attestations' => $attestations,
        ]);
    }
    /**
     * @Route("/entreprise", name="attestation_index_entreprise", methods={"GET"})
     */
    public function indexAttestationEntreprise(): Response
    {
        $attestations = $this->getDoctrine()
            ->getRepository(Attestation::class)
            ->findAll();

        return $this->render('attestation/afficher_attestation_entreprise.html.twig', [
            'attestations' => $attestations,
        ]);
    }

    /**
     * @Route("/new", name="attestation_new", methods={"GET","POST"})
     */
    public function new(Request $request,\Swift_Mailer $mailer): Response
    {
        $attestation = new Attestation();
       // $attestation->setDatepublication(new \DateTime('now')); //Afficher la date actuelle
        $form = $this->createForm(AttestationType::class, $attestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attestation);
            $entityManager->flush();

            $att=$form->getData();
            $message = (new \Swift_Message('Nouvelle Demande attestation'))
                ->setFrom('mohamedyassine.gadhoum@esprit.tn')
                ->setTo($att->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/email_attestation.html.twig', compact('att')
                    ),
                    'text/html'

                )
                ;
            $mailer->send($message);




            return $this->redirectToRoute('attestation_index');
        }

        return $this->render('attestation/new_attestation.html.twig', [
            'attestation' => $attestation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/send", name="attestation_send", methods={"GET","POST"})
     */
    public function EnvoyerAttestation(Request $request,\Swift_Mailer $mailer,Attestation $attestation): Response
    {

        $form = $this->createForm(SendAttestationType::class, $attestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');

            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);


            $att=$form->getData();

            $html=$att->getDomaine();

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $a=$dompdf->render();


            $message = (new \Swift_Message('Attestation'))
                ->setFrom('mohamedyassine.gadhoum@esprit.tn')
                ->setTo($att->getEmail())
                ->setBody($a);
            $mailer->send($message);

            return $this->redirectToRoute('attestation_index_entreprise');
        }

        return $this->render('attestation/send_attestation.html.twig', [
            'attestation' => $attestation,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="attestation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Attestation $attestation): Response
    {
        $form = $this->createForm(AttestationModifType::class, $attestation);
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
    /**
     * @Route("/admin/searchDomaineajax", name="ajaxsearch")
     */
    public function searchOffreajax(Request $request,NormalizerInterface $Normalizer,attestationRepository $repository)
    {

        $requestString=$request->get('searchValue');
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = 'SELECT * FROM attestation WHERE domaine LIKE "%'.$requestString.'%"';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll();
        return $this->render('attestation/searchdomaine.html.twig', [
            "attestations"=>$array
        ]);
    }

    /*
    /**
     * @Route("/search{domaine}",name="searchdomaine")
     */
    /*
    public function SearchEventByDomaine(Request $request){

        $data = $request->get('search');
        $repository = $this->getDoctrine()->getRepository(Attestation::class);
        $reclamation = $repository->findBy(['domaine'=>$data]);
        return $this->render('attestation/searchdomaine.html.twig',[
            'reclamations'=>$reclamation
        ]);
    }*/

}
