<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Film;
use App\Entity\Projection;


class HomeController extends AbstractController
{

    // route 1

    #[Route('/home', name: 'app_home')]
    public function index(FilmRepository $filmRepository): Response
    {
        // on met dans la variable $article le contenu de la fonctions findAll() du repo ArticleRepository qui sert a aller chercher tous les articles de la base, ce sont des fonctions déjà définis.
        // + commentaires dans "CategorieController.php"
        $films = $filmRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'films' => $films
        ]);
    }

    #[Route('/showFilm/{id}', name: 'show_film')]
    public function InfoFilm(int $id, FilmRepository $filmRepository): Response
    {





        // on doit créer un nouveau object vide de la classe Article pour que le formulaire se base sur cet object pour créer le formulaire
        // on peut aussi déjà pré remplir le formulaire avec les valeur d'un article séléctionné pour faire un formulaire d'update d'article
        $film = $filmRepository->find($id);

        return $this->render('home/showFilm.html.twig', [
            'controller_name' => 'HomeController',
            'film' => $film

        ]);




    }



}