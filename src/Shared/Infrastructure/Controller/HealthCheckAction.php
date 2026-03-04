<?php

namespace App\Shared\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/healthcheck', name: 'healthcheck', methods: ['GET'])]
class HealthCheckAction
{
    public function __invoke(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
