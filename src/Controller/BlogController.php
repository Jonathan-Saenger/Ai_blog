<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('home/blog.html.twig', [
            'articles' => $articleRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(ArticleRepository $articleRepository, int $id): Response
    {
        $article = $articleRepository->find($id);

        if (!$article) {
            throw $this->createNotFoundException("Article non trouvé !");
        }

        return $this->render('partials/article_show.html.twig', [
            'article' => $article,
        ]);
    }
}
