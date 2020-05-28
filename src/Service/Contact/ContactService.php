<?php
namespace App\Service\Contact;

use App\Entity\Contact;
use Twig\Environment;

class ContactService
{
    private $mailer;
    private $renderView;

    public function __construct(\Swift_Mailer $mailer, Environment $renderView)
    {
        $this->mailer = $mailer;
        $this->renderView = $renderView;

    }
    
    /**
     * Envoie email
     *
     * @param Contact $contact
     * @return void
     */
    public function sendEmail(Contact $contact)
    {
        $message = (new \Swift_Message('Votre demande'))
            ->setFrom($contact->getEmail())
            ->setTo('jamitien@gmail.com')
            ->setBody(
                $this->renderView->render('emails/contact.html.twig', [
                        'contact' => $contact
                    ]
                ), 
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}

