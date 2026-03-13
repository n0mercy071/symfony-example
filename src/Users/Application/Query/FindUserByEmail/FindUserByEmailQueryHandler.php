<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

class FindUserByEmailQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(FindUserByEmailQuery $query): ?UserDTO
    {
        $user = $this->userRepository->findByEmail($query->email);

        if (is_null($user)) {
            return null;
        }

        return UserDTO::fromEntity($user);
    }
}
