<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        // on met dans la variable $article le contenu de la fonctions findAll() du repo ArticleRepository
        $article = $articleRepository->findAll();

        $articlesRecherche = $articleRepository->findByTitre("Gants");
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $article,
            'articlesRecherche' => $articlesRecherche
        ]);
    }
}
