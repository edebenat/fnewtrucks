<?php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(VehicleRepository $vehicleRepository): Response
    {
        $vehicles = $vehicleRepository->findBy(['active' => true], ['createdAt' => 'DESC']);

        return $this->render('default/home.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }
}
