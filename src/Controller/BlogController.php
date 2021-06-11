<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(['valid'=>true], ['publishedAt'=>'DESC']);
        
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles ,
        ]);
    }



    /**
     * @Route("/article/{slug}", name="article_detail")
     */
    public function articleDetail(Article $article): Response
    {
               
        return $this->render('blog/article.html.twig', [
            'article' => $article ,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
               
        return $this->render('blog/about.html.twig', [
           
        ]);
    }

    /**
     * @Route("/page/{page}", name="static_pages")
     */
    public function staticPages($page = null): Response
    {
        if ($page == null) {
            return $this->redirectToRoute('home');
        }       
        return $this->render('blog/'.$page.'.html.twig', [
           
        ]);
    }
}
