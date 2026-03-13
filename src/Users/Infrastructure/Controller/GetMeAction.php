<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Controller;

use App\Shared\Domain\Security\UserFetcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/users/me', methods: ['GET'])]
readonly class GetMeAction
{
    public function __construct(private UserFetcherInterface $userFetcher)
    {
    }

    public function __invoke(): JsonResponse
    {
        $user = $this->userFetcher->getAuthUser();

        return new JsonResponse([
            'ulid' => $user->getUlid(),
            'email' => $user->getEmail(),
        ]);
    }
}
