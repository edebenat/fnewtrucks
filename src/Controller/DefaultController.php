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
        $vehicles = $vehicleRepository->findBy(['active' => true], ['createdAt' => 'DESC'], 4);

        return $this->render('default/home.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(VehicleRepository $vehicleRepository): Response
    {
        $newVehicle = $vehicleRepository->findOneBy(['active' => true], ['createdAt' => 'DESC']);
        $vehicles = $vehicleRepository->findBy(['active' => true], ['createdAt' => 'DESC'], null, 1);

        return $this->render('default/vehicules.html.twig', [
            'newVehicle' => $newVehicle,
            'vehicles' => $vehicles,
        ]);
    }
}
