<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliment", name="admin_aliment")
     */
    public function index(AlimentRepository $repository)
    {
        $aliments = $repository->findAll();
        return $this->render('admin_admin_aliment/adminAliment.html.twig',[
            "aliments" => $aliments
        ]);
    }

    /**
     * @Route("/admin/aliment{id}", name="admin_aliment_modification")
     */
    public function modifierAliment(Aliment $aliment, Request $request, EntityManagerInterface $manager)
    {


        $form = $this->createForm(AlimentType::class, $aliment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($aliment);
            $manager->flush();
            return $this->redirectToRoute("admin_aliment");
        }

        return $this->render('admin_admin_aliment/modificationAliment.html.twig',[
           "aliment" => $aliment,
           "form" => $form->createView()
        ]);
    }
}
