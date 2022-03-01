<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\ArticleRepository;
use App\Repository\BlogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_home')]
    public function index(BlogRepository $blogRepository, ArticleRepository $articleRepository): Response
    {
        $newest = $blogRepository->findNewest();
        $blogs = $blogRepository->findLast(3);
        $articles = $articleRepository->findLast(3);

        return $this->render('blog/index.html.twig', [
            'title' => 'blog',
            'newest' => $newest,
            'blogs' => $blogs,
            'articles' => $articles,
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(BlogRepository $blogRepository, int $id): Response
    {
        $blog = $blogRepository->find($id);

        return $this->render('blog/show.html.twig', [
            'title' => 'blog',
            'blog' => $blog,
        ]);
    }
}
