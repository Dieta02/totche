<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Form\SitesType;
use App\Repository\CategoriesRepository;
use App\Repository\CountriesRepository;
use App\Repository\DepartmentsRepository;
use App\Repository\SitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sites')]
class SitesController extends AbstractController
{
    #[Route('/', name: 'app_sites_index', methods: ['GET', 'POST'])]
    public function new(EntityManagerInterface $entityManager, Request $request, CountriesRepository $countriesRepository, SitesRepository $sitesRepository, CategoriesRepository $categoriesRepository, DepartmentsRepository $departmentsRepository): Response
    {
        $site = new Sites();

        if ($request->request->count() > 0) {
            //dd($request);
            $site->setName($request->request->get('name'));
            $site->setCity($request->request->get('city'));
            $site->setDescription($request->request->get('description'));
            $site->setPhoneNumber($request->request->get('phoneNumber'));
            $site->setCountriesId($request->request->get('countriesId'));
            $site->setCategoriesId($request->request->get('categoriesId'));
            $site->setDepartmentsId($request->request->get('departmentsId'));

            $socials = array(
                'whatsapp' => 'www.wa.me/' . $request->request->get('wa') . '',
                'facebook' => 'www.facebook.com/' . $request->request->get('fb') . '',
                'instagram' => 'www.instagram.com/' . $request->request->get('ig') . '',
                'tumblr' => 'www.tiktok.com/' . $request->request->get('tk') . '',
                'twitter' => 'www.twitter.com/' . $request->request->get('tw') . '',
                'linkedin' => 'www.linkedin.com/' . $request->request->get('in') . '',
            );

            $uploadDir = $this->getParameter('brochures_directory');
            $pictures = $request->files->get('pictures');
            $files = array();
            if ($pictures) {
                foreach ($pictures as $picture) {
                    $fileName1 = md5(uniqid()) . '.' . $picture->guessExtension();
                    $picture->move($uploadDir, $fileName1);
                    array_push($files, $fileName1);
                }

                $site->setPictures($files);
            }

            $site->setSocials($socials);
            $entityManager->persist($site);
            $entityManager->flush();
            return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sites/index.html.twig', [
            'site' => $site,
            'departments' => $departmentsRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'countries' => $countriesRepository->findAll(),
            'sites' => $sitesRepository->findAll(),

        ]);
    }
    #[Route('/{id}/edit', name: 'app_sites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sites $site, SitesRepository $sitesRepository): Response
    {
        $form = $this->createForm(SitesType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sitesRepository->save($site, true);

            return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sites/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sites_delete', methods: ['POST'])]
    public function delete(Request $request, Sites $site, SitesRepository $sitesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $site->getId(), $request->request->get('_token'))) {
            $sitesRepository->remove($site, true);
        }

        return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
    }
}
