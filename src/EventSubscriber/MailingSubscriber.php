<?php

namespace App\EventSubscriber;

use App\Event\ContactRequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailingSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function onMaterialQuantityIsEmpty(ContactRequestEvent $event): void
    {
        $product = $event->product;

        $email = (new Email())
            ->from('no-reply@domain.com')
            ->to($_ENV['CONTACT_MAIL'])
            ->subject('Rupture de stock '.$product)
            ->text('Le matériel '.$product.' est en rupture de stock.');

        $this->mailer->send(message: $email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactRequestEvent::class => 'onMaterialQuantityIsEmpty',
        ];
    }
}
