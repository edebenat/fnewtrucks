<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Entity\Vehicle;
use App\Form\ContactType;
use App\Repository\ActuRepository;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(VehicleRepository $vehicleRepository, ActuRepository $actuRepository): Response
    {
        $vehicles = $vehicleRepository->findBy(['active' => true], ['createdAt' => 'DESC'], 4);
        $actus = $actuRepository->findPublishedActu();

        return $this->render('default/home.html.twig', [
            'vehicles' => $vehicles,
            'actus' => $actus
        ]);
    }

    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(VehicleRepository $vehicleRepository, Request $request, MailerInterface $mailer): Response
    {
        $newVehicle = $vehicleRepository->findOneBy(['active' => true], ['createdAt' => 'DESC']);
        $vehicles = $vehicleRepository->findBy(['active' => true], ['createdAt' => 'DESC'], null, 1);
        $vehiclesList = $vehicleRepository->findBy(['active' => true], ['createdAt' => 'DESC']);

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $tel = $form->get('tel')->getData();
            $vehicle = $vehicleRepository->find($form->get('vehicle')->getData());

            $title = $vehicle->getModel().' '.$vehicle->getState();
            $mail =(new Email())
                ->from('ne-pas-repondre@fnewtrucks.fr')
                ->to('marketing@fnewtrucks.fr')
                ->subject('F New Trucks : Quelqu\'un est interressé par un véhicule')
                ->html("<h1>$title</h1><p>Nom : $firstname $lastname<br>Email : $email<br>Téléphone : $tel</p>")
            ;
    
            $mailer->send($mail);
    
            return $this->render('default/confirm-email.html.twig');
        }

        return $this->render('default/vehicules.html.twig', [
            'newVehicle' => $newVehicle,
            'vehicles' => $vehicles,
            'vehiclesList' => $vehiclesList,
            'form' => $form->createView()
        ]);
    }

    #[Route('/vehicules/{id}', name: 'vehicule')]
    public function vehicule(Vehicle $vehicle, Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $tel = $form->get('tel')->getData();

            $title = $vehicle->getModel().' '.$vehicle->getState();
            $mail =(new Email())
                ->from('ne-pas-repondre@fnewtrucks.fr')
                ->to('marketing@fnewtrucks.fr')
                ->subject('F New Trucks : Quelqu\'un est interressé par un véhicule')
                ->html("<h1>$title</h1><p>Nom : $firstname $lastname<br>Email : $email<br>Téléphone : $tel</p>")
            ;
    
            $mailer->send($mail);
    
            return $this->render('default/confirm-email.html.twig');
        }

        return $this->render('default/vehicule.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView()
        ]);
    }

    #[Route('/actus', name: 'actus')]
    public function actus(ActuRepository $actuRepository): Response
    {
        $actus = $actuRepository->findPublishedActu();

        return $this->render('default/actus.html.twig', [
            'actus' => $actus,
        ]);
    }

    #[Route('/actu/{id}', name: 'actu')]
    public function actu(Actu $actu): Response
    {
        return $this->render('default/actu.html.twig', [
            'actu' => $actu,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig');
    }

    #[Route('/garantie', name: 'garantie')]
    public function garantie(): Response
    {
        return $this->render('default/garantie.html.twig');
    }

    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentions_legales(): Response
    {
        return $this->render('default/mentions-legales.html.twig');
    }

    #[Route('/politique-de-confidentialite', name: 'politique_de_confidentialite')]
    public function politique_de_confidentialite(): Response
    {
        return $this->render('default/politique-de-confidentialite.html.twig');
    }

    #[Route('/sendEmail', name: 'sendEmail')]
    public function sendEmail(): Response
    {
        return $this->render('default/confirm-email.html.twig');
    }

    #[Route('/ajax/send_mail', name: 'send_mail', options: ['expose' => true])]
    public function send_mail(Request $request, VehicleRepository $vehicleRepository, MailerInterface $mailer): JsonResponse
    {
        $id = $request->request->get('id');
        $vehicle = $vehicleRepository->find($id);
        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $tel = $request->request->get('tel');

        $title = $vehicle->getModel().' '.$vehicle->getState();
        $mail =(new Email())
            ->from('ne-pas-repondre@fnewtrucks.fr')
            ->to('marketing@fnewtrucks.fr')
            ->subject('F New Trucks : Quelqu\'un est interressé par un véhicule')
            ->html("<h1>$title</h1><p>Nom : $firstname $lastname<br>Email : $email<br>Téléphone : $tel</p>")
        ;

        $mailer->send($mail);

        $html = $this->render('default/confirm-email.html.twig')->getContent();

        return $this->json([
            'html' => $html
        ]);
    }
}
