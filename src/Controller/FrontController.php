<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(WishRepository $repo): Response
    {
        $wishes = $repo->findBy(
            ['isPublished' => true],
            ['dateCreated' => 'ASC']);

        return $this->render('front/home.html.twig', [
            'wishes' => $wishes,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('front/contact.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/about-us", name="about")
     */
    public function about(): Response
    {
        return $this->render('front/about.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail(Wish $wish): Response
    {

        return $this->render('front/detail.html.twig', [
            'wish' => $wish,
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request,EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        // relier $wish au formulaire
        $formWish = $this->createForm(WishType::class,$wish);
        // Hydrater le $wish
        $formWish->handleRequest($request);
        if ( $formWish->isSubmitted()){
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('back/ajouter.html.twig', [
            'formWish' =>  $formWish->createView(),
        ]);
    }
}
