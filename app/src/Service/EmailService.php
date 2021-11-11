<?php

namespace App\Service;

use App\Dto\MenuDto;
use App\Dto\RestaurantDto;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{
    private MailerInterface $mailer;
    private string $appEmail;

    public function __construct(MailerInterface $mailer, string $appEmail /* Binded value */)
    {
        $this->mailer = $mailer;
        $this->appEmail = $appEmail;
    }

    /**
     * @param string $recipient
     * @param RestaurantDto[] $restaurants
     * @throws TransportExceptionInterface
     */
    public function sendMenu(string $recipient, array $restaurants)
    {
        $email = (new TemplatedEmail())
            ->from($this->appEmail)
            ->to($recipient)
            ->subject('Menu for today')
            ->htmlTemplate('email/restaurant-menu-list.html.twig')
            ->context([
                "restaurants" => $restaurants
            ]);
        $this->mailer->send($email);
    }
}