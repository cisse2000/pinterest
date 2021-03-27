<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Secure;
use Symfony\Component\BrowserKit\Request;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("",name="app_admin_index", methods={"GET"})
     */
    public function index( Request $request): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')){
            $this->redirectToRoute('app_login');
        }


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/create",name="app_admin_create", methods={"GET"})
     */
    public function create(): Response
    {
        return $this->render('admin/create.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
