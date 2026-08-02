<?php

namespace App\Service;
use App\Entity\RendezVous;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
    ) {

    }


public function sendConfirmationEmail(RendezVous $rendezVous): void
{
    $email = (new Email())
        ->from('contact@headspa.fr')
        ->to($rendezVous->getUser()->getEmail())
        ->subject('Votre rendez-vous est confirmé')
        ->text(
            sprintf(
                "Bonjour %s,\n\nVotre rendez-vous du %s a été confirmé.\n\nÀ bientôt !",
                $rendezVous->getUser()->getPrenom(),
                $rendezVous->getDateHeure()->format('d/m/Y à H:i')
            )
        );

    $this->mailer->send($email);
}
}