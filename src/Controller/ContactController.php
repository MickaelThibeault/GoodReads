<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $data = new ContactDTO();

        $data->name = 'John Doe';
        $data->email = 'john.doe@contact.fr';
        $data->message = 'Super Site !';

        $form = $this->createForm(ContactType::class, $data);

        $form->handleRequest($request, $data);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($data->email)
                ->to('contact@example.com')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Demande de contact')
                ->htmlTemplate('email/contact.html.twig')
                ->context(['data' => $data])
            ;

            $this->addFlash('success', 'Le mail a bien été envoyé');
            $this->redirectToRoute('app_contact');

            $mailer->send($email);
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
