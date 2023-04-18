<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AppHelpers;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminController extends AbstractController
{
    private $app;
    private $db;
    private $userInfo;
    private $session;

    public function __construct(ManagerRegistry $doctrine,  AppHelpers $app, RequestStack $requestStack)
    {
        $this->app = $app;
        $this->db = $doctrine->getManager();
        $this->userInfo = $app->getUser();
        $this->session = $requestStack->getSession();
    }

    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/index.html.twig', [
            'userInfo' => $this->userInfo,
            'bodyId' => $this->app->getBodyId('ADMIN_PAGE'),
        ]);
    }

    public function memberManagement(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        return $this->render('admin/member-management.html.twig', [
            'userInfo' => $this->userInfo,
            'bodyId' => $this->app->getBodyId('ADMIN_MEMBER_MANAGEMENT_PAGE'),
        ]);
    }
}
