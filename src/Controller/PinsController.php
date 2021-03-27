<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;

        // if($this->isGranted('ROLE_ADMIN')){
        //     dd("Accordé");
        // } else {
        //     dd("Non Permis ! ");
        // }
    }

    /**
     *@Route("/", name="app_home", methods={"GET"})
    */
    public function index(PinRepository $pinRepository): Response
    {
        return $this->render('pins/index.html.twig', [
            'pins' => $pinRepository->findBy([])
        ]);
    }

    /**
     *@Route("/pin/create", name="app_pin_create", methods={"GET","POST"})
    */
    public function create(Request $request, UserRepository $userRepository): Response
    {
        $pin = new Pin;
        $form = $this->createForm(PinType::class,$pin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $pin->setUser($this->getUser());
            // dd($pin);
            $this->em->persist($pin);
            $this->em->flush();

            $this->addFlash("success","Ajout effectué avec succès");

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *@Route("/pin/{id}", name="app_pin_show", methods={"GET"})
    */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', [
            'pin' => $pin
        ]);
    }

    /**
     *@Route("/pin/{id}/edit", name="app_pin_edit", methods={"GET","PUT"})
    */
    public function edit(Pin $pin, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $form = $this->createForm(PinType::class,$pin,[
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManagerInterface->persist($pin);
            $entityManagerInterface->flush();

            $this->addFlash("success","Modification éffectuée avec succès!");

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *@Route("/pin/{id}", name="app_pin_delete", methods={"GET","DELETE"})
    */
    public function delete(Request $request, Pin $pin): Response
    {

        if($this->isCsrfTokenValid('pin_deletion_'. $pin->getId() ,$request->request->get('csrf_token'))){
            $this->em->remove($pin);
            $this->em->flush();
            $this->addFlash("danger","Suppression éffectuée avec succès!");
        }
        return $this->redirectToRoute("app_home");
    }


}
