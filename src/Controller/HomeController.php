<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Service\ContactFormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    public function __construct(
        private ContactFormService $contactFormService
    ) {}

    #[Route('/', name: 'app_home')]
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $form = $this->contactFormService->createContactForm();

        if ($this->contactFormService->handleContactForm($request, $form)) {
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC'], 3),
            'form' => $form->createView(),
        ]);
    }
}