<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Projet;
use App\Form\PatientType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;

class AnalyseController extends AbstractController

{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/etudiant/projetss', name: 'app_analyse_index', methods: ['GET'])]
    public function index(ProjetRepository $patientRepository): Response
    {
        return $this->render('analyse/index.html.twig', [
            'patients' => $patientRepository->findAll(),
        ]);
    }
    #[Route('/choisir/{id}', name: 'app_choisir_projet', methods: ['POST'])]
    public function choisirProjet(Request $request, Projet $projet): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur courant

        // Si l'utilisateur est connecté
        if ($user) {
            // Associer l'utilisateur au projet
            $projet->setEtudiant($user);

            // Enregistrer les modifications en base de données
            $this->entityManager->flush();
        }

        // Rediriger vers la page d'accueil ou une autre page
        return $this->redirectToRoute('app_analyse_index');
    }
}
