<?php

namespace App\Controller;

use App\Entity\Guides;
use App\Form\GuidesType;
use App\Repository\CountriesRepository;
use App\Repository\GuidesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/guides')]
class GuidesController extends AbstractController
{
    #[Route('/', name: 'app_guides_index', methods: ['GET', 'POST'])]
    public function index(Request $request, GuidesRepository $guidesRepository, CountriesRepository $countriesRepository, EntityManagerInterface $entityManager): Response
    {
        $guide = new Guides();
        if ($request->request->count() > 0) {
            //dd($request);
            $guide->setName($request->request->get('name'));
            $guide->setSurname($request->request->get('surname'));
            $guide->setPhoneNumber($request->request->get('phoneNumber'));
            $guide->setCountriesId($request->request->get('countriesId'));
            $socials = array(
                'whatsapp' => 'www.wa.me/' . $request->request->get('wa') . '',
                'facebook' => 'www.facebook.com/' . $request->request->get('fb') . '',
                'instagram' => 'www.instagram.com/' . $request->request->get('ig') . '',
                'tumblr' => 'www.tiktok.com/' . $request->request->get('tk') . '',
                'twitter' => 'www.twitter.com/' . $request->request->get('tw') . '',
                'linkedin' => 'www.linkedin.com/' . $request->request->get('in') . '',
            );

            $uploadDir = $this->getParameter('brochures2_directory');
            $profilPicture = $request->files->get('profilPicture');
            if ($profilPicture) {
                $fileName = md5(uniqid()) . '.' . $profilPicture->guessExtension();
                $profilPicture->move($uploadDir, $fileName);
                $pictures = $request->files->get('pictures');
                $guide->setProfilPicture($fileName);
            }
            $pictures = $request->files->get('pictures');
            $files = array();
            if ($pictures) {
                foreach ($pictures as $picture) {
                    $fileName1 = md5(uniqid()) . '.' . $picture->guessExtension();
                    $picture->move($uploadDir, $fileName1);
                    array_push($files, $fileName1);
                }

                $guide->setPictures($files);
            }

            $guide->setSocials($socials);
            $entityManager->persist($guide);
            $entityManager->flush();
            return $this->redirectToRoute('app_guides_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('guides/index.html.twig', [
            'guides' => $guidesRepository->findAll(),
            'guide' => $guide,
            'countries' => $countriesRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_guides_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guides $guide, GuidesRepository $guidesRepository): Response
    {
        $form = $this->createForm(GuidesType::class, $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guidesRepository->save($guide, true);

            return $this->redirectToRoute('app_guides_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guides/index.html.twig', [
            'guide' => $guide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_guides_delete', methods: ['POST'])]
    public function delete(Request $request, Guides $guide, GuidesRepository $guidesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $guide->getId(), $request->request->get('_token'))) {
            $guidesRepository->remove($guide, true);
        }

        return $this->redirectToRoute('app_guides_index', [], Response::HTTP_SEE_OTHER);
    }
}
