<?php

namespace App\Service;

use App\Entity\Contact;
use App\Form\ContactForm;
use App\Repository\ContactRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ContactFormService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private MailerInterface $mailer,
        private ContactRepository $contactRepository,
        private string $contactEmail
    ) {}

    public function createContactForm(): FormInterface
    {
        return $this->formFactory->create(ContactForm::class, new Contact());
    }

    public function handleContactForm(Request $request, FormInterface $form): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Contact $contact */
            $contact = $form->getData();

            // Persister le message de contact
            $this->contactRepository->save($contact, true);

            // Envoyer l'email
            $this->sendContactEmail($contact);

            return true;
        }

        return false;
    }

    private function sendContactEmail(Contact $contact): void
    {
        $email = (new Email())
            ->from('mail@aidevsec.jonathansaenger.fr')
            ->replyTo($contact->getEmail())
            ->to($this->contactEmail)
            ->subject('Contact via site web: ' . $contact->getSubject())
            ->html(
                $this->renderEmailTemplate($contact)
            );

        $this->mailer->send($email);
    }

    private function renderEmailTemplate(Contact $contact): string
    {
        // Idéalement, utilisez Twig pour le template email
        return "<h1>Nouveau message de contact</h1>
                <p><strong>Nom:</strong> {$contact->getName()}</p>
                <p><strong>Email:</strong> {$contact->getEmail()}</p>
                <p><strong>Sujet:</strong> {$contact->getSubject()}</p>
                <p><strong>Message:</strong></p>
                <p>{$contact->getMessage()}</p>";
    }
}