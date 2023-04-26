<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\ByteString;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/subscribe', name: 'newsletter_subscribe')]
    public function subscribe(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter->setToken(ByteString::fromRandom(32)->toString());

            $em->persist($newsletter);
            $em->flush();
            $email = (new Email())
                ->from('admin@hb-corp.com')
                ->to($newsletter->getEmail())
                ->subject('Inscription à la newsletter')
                ->text($this->generateUrl(
                    'newsletter_confirm',
                    ['token' => $newsletter->getToken()],
                    UrlGeneratorInterface::ABSOLUTE_URL
                ));

            $mailer->send($email);
        }
        return $this->renderForm('newsletter/subscribe.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/newsletter/confirm/{token}', name: 'newsletter_confirm')]
    public function confirm(Newsletter $newsletter, EntityManagerInterface $em): Response
    {
        $newsletter
            ->setActive(true)
            ->setToken(null);

        $em->flush();

        return $this->redirectToRoute('app_index');
    }
}
