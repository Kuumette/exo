<?php

namespace App\Controller;

use App\Entity\Label;
use App\Entity\Contact;
use App\Form\LabelType;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LabelController extends AbstractController
{
    /**
     * @Route("/label", name="label")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, LabelRepository $labelRepo): Response {

        $label = new Label();

        $form = $this->createForm(LabelType::class, $label);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // sans injecter le dependance 'EntityManagerInterface $entityManager' dans ma fonction !
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($label);
            $entityManager->flush();

            return $this->redirecttoRoute('home');
        }

        return $this->render('label/index.html.twig', [
            'formulaire' => $form->createView(),
            'labels' => $labelRepo->findAll(),
        ]);
    }
}
