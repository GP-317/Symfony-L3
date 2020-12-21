<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Form\UserTypeClient;


/**
 * @Route("/mon-espace-agent")
 */
class AgentController extends AbstractController
{

    /**
     * @Route("/", name="agent_home", methods={"GET","POST"})
     */
    public function index(UserRepository $userRepository, Request $request): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser(); 

        // Créer un formulaire lié à ce utilisateur
        $form = $this->createForm(UserTypeClient::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

        }

        return $this->render('espace-agent/index.html.twig', [
            'form' => $form->createView()
        ]);
    }



}


