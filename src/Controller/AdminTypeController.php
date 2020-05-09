<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeController extends AbstractController
{
    /**
     * @Route("/admin/type", name="admin_types")
     */
    public function index(TypeRepository $repo)
    {
        $types = $repo->findAll();
        
        return $this->render('admin_type/adminType.html.twig', [
            "types" => $types
        ]
        );
    }

    /**
     * @Route("/admin/type/create", name="ajoutType")
     * @Route("/admin/type/{id}", name="modifType", methods="POST|GET")
     */
    public function ajoutEtModif(Type $type = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$type){
            $type =new Type();
        }
        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($type);
            $manager->flush();
            $this->addFlash('success', "L'action a bien été réalisée");
            return $this->redirectToRoute("admin_types");
        }
        
        return $this->render('admin_type/ajoutEtModif.html.twig', [
            "type" => $type,
            "form" => $form->createView()
        ]
        );
    }

    /**
     * @Route("/admin/type/{id}", name="supType", methods="delete")
     */
    public function suppression(Type $type, EntityManagerInterface $manager, Request $request)
    {
        if($this->isCsrfTokenValid('SUP'.$type->getId(), $request->get('_token'))){
            $manager->remove($type);
            $manager->flush();
            $this->addFlash('success', "L'action a bien été réalisée");
            return $this->redirectToRoute("admin_types");
        }
    }
}
