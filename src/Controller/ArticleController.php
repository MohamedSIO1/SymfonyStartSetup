<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted; // à mettre pour utiliser IsGranted
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




// on met IsGranted ici pour appliquer le role à tous le Controller
class ArticleController extends AbstractController
{



    // initialise le role minimum de l'user, on le met ici pour uniquement appliquer le role à la méthode add() et pas à tous le controller
    #[IsGranted('ROLE_USER')]
    #[Route('/addarticle', name: 'add_article')]
    public function AddArticle(Request $request, EntityManagerInterface $em,): Response
    {

        // si l'user est pas co, on redirige vers la page login


        // on doit créer un nouveau object vide de la classe Article pour que le formulaire se base sur cet object pour créer le formulaire
        // on peut aussi déjà pré remplir le formulaire avec les valeur d'un article séléctionné pour faire un formulaire d'update d'article
        $article = new Article();
        $article->setAuteur($this->getUser());
        $article->setDateCreation(new \DateTime());



        // ----------------- FORMULAIRE ----------------- //

        // on creer une variable $form qui va créer un formulaire avec la fonction createForm() qui prend en entrée la page du formulaire ArticleType et l'object $article sur lequel il va se baser
        $form = $this->createForm(ArticleType::class, $article);

        // on récupère toutes les choses qui ont été saisi par l'utilisateur 
        $form->handleRequest($request);

        // Si le formulaire à été soumis et est valid on fait le reste
        if ($form->isSubmitted() && $form->isValid()) {

            // on envoi les données du formulaire précédemment réucpérer avec handleRequest() en haut et on les met dans la var $article avec getData() car ça correspond à un nouveau article qu'on veut ajouter dans le cas présent
            $article = $form->getData();
            // on sauvegarde en bdd

            // on met en "surveillance" $article pour prévenir qu'il se passe des choses dessus
            $em->persist($article);
            // on execute en bdd la requête (insert,update,delete,etc..) avec flush()
            $em->flush();

            // on redirige vers la home après que l'article ai été ajouter en bdd, fin du traitement
            return $this->redirectToRoute('app_home');
        }

        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/editArticle/{id}', name: 'edit_article')]
    public function EditArticle(int $id, Request $request, EntityManagerInterface $em, ArticleRepository $articleRepository): Response
    {



        // ici ce code ne serg à rien car ISGranted fonctionne mais si ça ne marcherais pas, ça aurait le meme résultat (fais par sofiane): si l'user est pas co, on redirige vers la page login
        if (!$this->getUser()) {

            // fonction de redirection 
            return $this->redirectToRoute('app_login');
        } else {
        }


        // on doit créer un nouveau object vide de la classe Article pour que le formulaire se base sur cet object pour créer le formulaire
        // on peut aussi déjà pré remplir le formulaire avec les valeur d'un article séléctionné pour faire un formulaire d'update d'article
        $article = $articleRepository->find($id);




        // ----------------- FORMULAIRE ----------------- //

        // on creer une variable $form qui va créer un formulaire avec la fonction createForm() qui prend en entrée la page du formulaire ArticleType et l'object $article sur lequel il va se baser
        $form = $this->createForm(ArticleType::class, $article);

        // on récupère toutes les choses qui ont été saisi par l'utilisateur 
        $form->handleRequest($request);

        // Si le formulaire à été soumis et est valid on fait le reste
        if ($form->isSubmitted() && $form->isValid()) {

            // on envoi les données du formulaire précédemment réucpérer avec handleRequest() en haut et on les met dans la var $article avec getData() car ça correspond à un nouveau article qu'on veut ajouter dans le cas présent
            $article = $form->getData();
            // on sauvegarde en bdd

            // on met en "surveillance" $article pour prévenir qu'il se passe des choses dessus
            $em->persist($article);
            // on execute en bdd la requête (insert,update,delete,etc..) avec flush()
            $em->flush();

            // on redirige vers la home après que l'article ai été ajouter en bdd, fin du traitement
            return $this->redirectToRoute('app_home');
        }

        return $this->render('article/add.html.twig', [
            'form' => $form,
        ]);
    }
}
