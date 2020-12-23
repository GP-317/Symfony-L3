<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;
use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserAdminType;
use App\Form\HomepageType;
use App\Entity\Homepage;
use App\Entity\Article;
use App\Entity\Offer;


// {"0":"ROLE_ADMIN","2":"ROLE_USER","3":"ROLE_AGENT"}


    /**
     * @Route("/admin")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/contact", name="contact_index", methods={"GET"})
     */
    public function indexContact(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user", name="adm_user_index", methods={"GET"})
     */
    public function indexUser(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/offer", name="adm_offer_index", methods={"GET"})
     */
    public function indexOffer(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/indexAdmin.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }


    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ARTICLE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function newArticle(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function editArticle(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function deleteArticle(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }


    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Homepage ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //


    /**
     * @Route("/homepage/new", name="homepage_new", methods={"GET","POST"})
     */
    public function newHomepage(Request $request): Response
    {
        $homepage = new Homepage();
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($homepage);
            $entityManager->flush();

            return $this->redirectToRoute('homepage_index');
        }

        return $this->render('homepage/new.html.twig', [
            'homepage' => $homepage,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/homepage/{id}/edit", name="homepage_edit", methods={"GET","POST"})
     */
    public function editHomepage(Request $request, Homepage $homepage): Response
    {
        $form = $this->createForm(HomepageType::class, $homepage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage_index');
        }

        return $this->render('homepage/edit.html.twig', [
            'homepage' => $homepage,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/homepage/{id}", name="homepage_delete", methods={"DELETE"})
     */
    public function deleteHomepage(Request $request, Homepage $homepage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homepage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($homepage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage_index');
    }


    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Utilisateur ~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //


    /**
     * @Route("/user/{id}/edit", name="adm_user_edit", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserAdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adm_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adm_user_index');
    }


    /**
     * @Route("/user/{id}", name="adm_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Offres ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ //


    /**
     * @Route("/offer/new", name="adm_offer_new", methods={"GET","POST"})
     */
    public function newOffer(Request $request): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('adm_offer_index');
        }

        return $this->render('offer/newAdmin.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/offer/{id}", name="adm_offer_delete", methods={"DELETE"})
     */
    public function deleteOffer(Request $request, Offer $offer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adm_offer_index');
    }

    /**
     * @Route("/offer/{id}", name="adm_offer_show", methods={"GET"})
     */
    public function showOffer(Offer $offer): Response
    {
        return $this->render('offer/showAdmin.html.twig', [
            'offer' => $offer,
        ]);
    }

    /**
     * @Route("/offer/{id}/edit", name="adm_offer_edit", methods={"GET","POST"})
     */
    public function editOffer(Request $request, Offer $offer): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adm_offer_index');
        }

        return $this->render('offer/editAdmin.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }






}
