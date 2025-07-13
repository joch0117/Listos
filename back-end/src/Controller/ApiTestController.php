<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiTestController extends AbstractController
{
    #[Route('/api/test', name: 'app_api_test')]
    public function index(): Response
    {
        return $this->json(['status'=>'ok']);
    }
}
