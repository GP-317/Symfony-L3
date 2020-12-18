<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }



    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article, ArticleRepository $articleRepository): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'articles' => $articleRepository->findAll(),
        ]);
    }

    

    
}
