<?php

namespace App\Controller;

use App\Entity\Blogs;
use App\Form\BlogsType;
use App\Repository\BlogsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blogs')]
class BlogsController extends AbstractController
{
    #[Route('/', name: 'app_blogs_index', methods: ['GET','POST'])]
    public function index(Request $request, BlogsRepository $blogsRepository,EntityManagerInterface $entityManager): Response
    {   $blog = new Blogs();
      if ($request->request->count() > 0) {
            //dd($request);
            $uploadDir = $this->getParameter('brochures4_directory');

            $picture = $request->files->get('picture');

            if ($picture) {
                    $fileName1 = md5(uniqid()) . '.' . $picture->guessExtension();
                    $picture->move($uploadDir, $fileName1);
                $blog->setPicture($fileName1);
            }
            $now=date('Y-m-d');
            $blog->setTitle($request->request->get('title'));
            $blog->setContent($request->request->get('content'));
            $blog->setPublicationDate(new \DateTime($now));
            $entityManager->persist($blog);
            $entityManager->flush();
            return $this->redirectToRoute('app_blogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blogs/index.html.twig', [
            'blogs' => $blogsRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_blogs_show', methods: ['GET'])]
    public function show(Blogs $blog): Response
    {
        return $this->render('blogs/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blogs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blogs $blog, BlogsRepository $blogsRepository): Response
    {
        $form = $this->createForm(BlogsType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $blogsRepository->save($blog, true);

            return $this->redirectToRoute('app_blogs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('blogs/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blogs_delete', methods: ['POST'])]
    public function delete(Request $request, Blogs $blog, BlogsRepository $blogsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $blogsRepository->remove($blog, true);
        }

        return $this->redirectToRoute('app_blogs_index', [], Response::HTTP_SEE_OTHER);
    }
}
