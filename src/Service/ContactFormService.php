<?php

namespace App\Service;

use App\Entity\Contact;
use App\Form\ContactForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactFormService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private MailerInterface $mailer
    ) {}

    public function createContactForm(?Contact $contact = null): FormInterface
    {
        $contact = $contact ?? new Contact();
        return $this->formFactory->create(ContactForm::class, $contact);
    }

    public function handleContactForm(Request $request, FormInterface $form): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contact */
            $contact = $form->getData();

            $email = (new Email())
                ->from($contact->getEmail())
                ->to('jonathan.saenger.pro@gmail.com')
                ->subject($contact->getSubject())
                ->html(sprintf(
                    '<p><strong>Nom :</strong> %s</p><p><strong>Email :</strong> %s</p><p><strong>Message :</strong> %s</p>',
                    $contact->getName(),
                    $contact->getEmail(),
                    $contact->getMessage()
                ));

            $this->mailer->send($email);

            return true;
        }

        return false;
    }
}