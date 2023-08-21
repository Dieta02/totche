<?php

namespace App\Controller;

use App\Repository\BlogsRepository;
use App\Repository\CategoriesRepository;
use App\Repository\GuidesRepository;
use App\Repository\SitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/acceuil', name: 'app_home')]
    public function index(SitesRepository $sitesRepository, CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('frontend/home.html.twig', [
            'sites' => $sitesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/categorie/{category}', name: 'app_categorySites')]
    public function category($category, SitesRepository $sitesRepository, CategoriesRepository $categoriesRepository): Response
    {
        $categoryId = $categoriesRepository->findOneBy(array('name' => $category));
        $sites = $sitesRepository->findBy(array('categoriesId' => $categoryId));
        return $this->render('frontend/categories.html.twig', [
            'sites' => $sites,
            'category' => $category,
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/site/{category}_{id}', name: 'app_siteView')]
    public function site($id, $category, SitesRepository $sitesRepository): Response
    {
        $site = $sitesRepository->findOneBy(array('id' => $id));
        return $this->render('frontend/site.html.twig', [
            'site' => $site,
            'category' => $category,
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/galerie', name: 'app_gallery')]
    public function galerie(SitesRepository $sitesRepository): Response
    {
        $sites = $sitesRepository->findAll();
        shuffle($sites);
        return $this->render('frontend/gallery.html.twig', [
            'sites' => $sites,
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/guides_touristiques', name: 'app_guideT')]
    public function guides(GuidesRepository $guidesRepository): Response
    {
        return $this->render('frontend/guide.html.twig', [
            'guides' => $guidesRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }
     #[Route('/blog', name: 'app_blogs')]
    public function blogs(BlogsRepository $blogsRepository): Response
    {
        return $this->render('frontend/blog.html.twig', [
            'blogs' => $blogsRepository->findAll(),
            'controller_name' => 'HomeController',
        ]);
    }
     #[Route('/blog/{id}', name: 'app_blog_single')]
    public function singleBlogs($id,BlogsRepository $blogsRepository): Response
    {
        return $this->render('frontend/blog-single.html.twig', [
            'blog' => $blogsRepository->findBy(['id'=>$id]),
            'controller_name' => 'HomeController',
        ]);
    }
     #[Route('/contact', name: 'app_contact',methods: ['GET', 'POST'])]
    public function contact(Request $request,MailerInterface $mailer): Response
    {
        if($request->request->count() > 0){
            $email=(new Email())
            ->from(new Address($request->request->get('email'),$request->request->get('name')))
            ->to('support@totche.com')
            ->subject('Contact Message')
            ->html($request->request->get('message'));
            $mailer->send($email);
        }
        return $this->render('frontend/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
