<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Entity\Vehicle;
use App\Form\ActuType;
use App\Form\VehicleType;
use App\Repository\ActuRepository;
use App\Repository\VehicleRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jass')]
class JassController extends AbstractController
{
    #[Route('/', name: 'app_jass_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('jass/home.html.twig');
    }

    #[Route('/vehicules', name: 'app_jass_index', methods: ['GET'])]
    public function index(VehicleRepository $vehicleRepository): Response
    {
        return $this->render('jass/index.html.twig', [
            'vehicles' => $vehicleRepository->findAll(),
        ]);
    }

    #[Route('/vehicules/new', name: 'app_jass_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehicle = new Vehicle();
        $vehicle->setCreatedAt(new DateTimeImmutable('now'));
        $vehicle->setActive(false);

        $entityManager->persist($vehicle);
        $entityManager->flush();

        return $this->redirectToRoute('app_jass_edit', [
            'id' => $vehicle->getId()
        ]);
        
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->redirectToRoute('app_jass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jass/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
        ]);
    }

    #[Route('/vehicules/{id}', name: 'app_jass_show', methods: ['GET'])]
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('jass/show.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    #[Route('/vehicules/{id}/edit', name: 'app_jass_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicle $vehicle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_jass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jass/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
        ]);
    }

    #[Route('/vehicules/{id}', name: 'app_jass_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicle $vehicle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vehicle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_jass_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/vehicules/{id}/activate', name: 'app_jass_activate')]
    public function activate(Vehicle $vehicle, EntityManagerInterface $entityManager): Response
    {
        if ($vehicle->isActive()) {
            $vehicle->setActive(false);
        }
        else {
            $vehicle->setActive(true);
        }
        $entityManager->persist($vehicle);
        $entityManager->flush();

        return $this->redirectToRoute('app_jass_index');
    }

    #[Route('/vehicules/ajax/new_picture', name: 'new_picture', options: ['expose' => true])]
    public function new_picture(Request $request, EntityManagerInterface $entityManager, VehicleRepository $vehicleRepository): JsonResponse
    {
        $image = $request->files->get('file');
        $id = $request->request->get('id');
        $vehicle = $vehicleRepository->find($id);
        $date = new DateTime('now');
        $name = $date->format('YmdHis');

        $position = 0;
        $images = $vehicle->getImages();
        if (!$images == null) {
            foreach ($images as $key => $value) {
                $position = $key + 1;
            }           
        }
        $src = 'images/vehicles/'.$id.'/'.$name.'.'.$image->guessExtension();

        if (file_exists($src)) {
            unlink($src);
        }
        $image->move('images/vehicles/'.$id, $name.'.'.$image->guessExtension());

        $images[$position] = $src;
        $vehicle->setImages($images);

        $entityManager->persist($vehicle);
        $entityManager->flush();

        $html = $this->render('jass/image.html.twig',[
            'image' => $src,
            'vehicle' => $vehicle,
            'key' => $position
        ])->getContent();

        return $this->json([
            'html' => $html
        ]);
    }

    #[Route('/vehicules/ajax/del_picture', name: 'del_picture', options: ['expose' => true])]
    public function del_picture(Request $request, VehicleRepository $vehicleRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $position = $request->request->get('position');
        $id = $request->request->get('id');

        $vehicle = $vehicleRepository->find($id);
        $images = $vehicle->getImages();

        if (file_exists($images[$position])) {
            unlink($images[$position]);
        }

        array_splice($images, $position, 1);
        $vehicle->setImages($images);

        $entityManager->persist($vehicle);
        $entityManager->flush();


        return $this->json([]);
    }

/* ---------------------------------------------------- */

    #[Route('/actus', name: 'jass_actus', methods: ['GET'])]
    public function actus(ActuRepository $actuRepository): Response
    {
        return $this->render('jass/actus/index.html.twig', [
            'actus' => $actuRepository->findAll(),
        ]);
    }

    #[Route('/actus/new', name: 'jass_actus_new', methods: ['GET', 'POST'])]
    public function jass_actus_new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actu = new Actu();
        $actu->setCreatedAt(new DateTimeImmutable('now'));
        $actu->setActive(false);

        $entityManager->persist($actu);
        $entityManager->flush();

        return $this->redirectToRoute('app_jass_edit', [
            'id' => $actu->getId()
        ]);
        
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($actu);
            $entityManager->flush();

            return $this->redirectToRoute('app_jass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jass/actus/edit.html.twig', [
            'actu' => $actu,
            'form' => $form,
        ]);
    }

    #[Route('/actus/{id}', name: 'jass_actus_show', methods: ['GET'])]
    public function jass_actus_show(Actu $actu): Response
    {
        return $this->render('jass/actus/show.html.twig', [
            'actu' => $actu,
        ]);
    }

    #[Route('/actus/{id}/edit', name: 'jass_actus_edit', methods: ['GET', 'POST'])]
    public function jass_actus_edit(Request $request, Actu $actu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('jass_actus', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jass/actus/edit.html.twig', [
            'actu' => $actu,
            'form' => $form,
        ]);
    }

    #[Route('/actus/{id}', name: 'jass_actus_delete', methods: ['POST'])]
    public function jass_actus_delete(Request $request, Actu $actu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jass_actus', [], Response::HTTP_SEE_OTHER);
    }

}
