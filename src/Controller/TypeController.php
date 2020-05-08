<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController
{
    /**
     * @Route("/types", name="types")
     */
    public function index(TypeRepository $repository)
    {
        $types = $repository->findAll();

        return $this->render('type/types.html.twig',[
            "types" => $types
        ]);
    }
}
