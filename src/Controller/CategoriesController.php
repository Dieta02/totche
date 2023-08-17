<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_categories_index', methods: ['GET', 'POST'])]
    public function index(Request $request, CategoriesRepository $categoriesRepository,EntityManagerInterface $entityManager): Response
    {
        $category = new Categories();
        if ($request->request->count() > 0) {
            //dd($request);
            $uploadDir = $this->getParameter('brochures3_directory');

            $picture = $request->files->get('picture');

            $category->setName($request->request->get('name'));
            if ($picture) {
                    $fileName1 = md5(uniqid()) . '.' . $picture->guessExtension();
                    $picture->move($uploadDir, $fileName1);
                    array_push($files, $fileName1);
                $category->setPicture($fileName1);
            }
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            'category' => $category,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriesRepository->save($category, true);

            return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categories_delete', methods: ['POST'])]
    public function delete(Request $request, Categories $category, CategoriesRepository $categoriesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            $categoriesRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
