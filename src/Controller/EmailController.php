<?php

namespace App\Controller;




use App\Entity\Email;
use App\Form\MailType;
use App\Repository\EmailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, EmailRepository $emailRepo): Response
    {
        $email = new Email();

        $form = $this->createForm(MailType::class, $email);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // sans injecter le dependance 'EntityManagerInterface $entityManager' dans ma fonction !
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($email);
            $entityManager->flush();

            return $this->redirecttoRoute('home');
        }

        return $this->render('email/index.html.twig', [
            'formulaire' => $form->createView(),
            'emails' => $emailRepo->findAll(),
        ]);
    }
}
