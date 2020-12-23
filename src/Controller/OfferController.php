<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\Souscription;

/**
 * @Route("/offer")
 */
class OfferController extends AbstractController
{

    /**
     * @Route("/", name="offer_index", methods={"GET"})
     */
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="offer_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

            return $this->redirectToRoute('offer_index');
        }

        return $this->render('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offer_show", methods={"GET"})
     */
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    
    /**
     * @Route("/subscribing_to/{id}", name="subscribe_to_offer", methods={"GET"})
     */
    public function subscribeToOffer(Offer $offer): Response
    {

        if ($this->getUser()) {

            $exists = false;
            $user = $this->getUser();

            if ($user->getVille() == "" || $user->getPays() == "" || $user->getNoSecu() == "" || $user->getCodePostal() == "" || $user->getNoTelephone() == "")
            {
                $this->addFlash('notice', 'Veuillez renseigner les champs manquants');
                return $this->redirectToRoute('user_home');
            } else
            {
                foreach ($user->getSouscription() as $subscription)
                {
                    if ($subscription->getOffer() == $offer)
                    {
                        $exists = true;
                        $this->addFlash('warning', 'Vous avez déjà souscrit à cette offre !');
                    }
                }
                if ($exists == false)
                {
                    $souscription = new Souscription($user, $offer);
                    $user->addSouscription($souscription);
                    $offer->addSouscription($souscription);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($souscription);
                    $em->flush();
                    return $this->render('espace-client/souscription.html.twig', [
                        'souscription' => $user->getSouscription(),
                    ]);
                }
            }
        }

        $this->addFlash('error', 'Vous devez être connecté pour souscrire à une offre !');
        return $this->redirectToRoute('app_login');
    }



}
