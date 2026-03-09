<?php

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @return string ULID пользователя
     */
    public function __invoke(CreateUserCommand $command): string
    {
        $user = new UserFactory()->create($command->email, $command->password);
        $this->userRepository->add($user);

        return $user->getUlid();
    }
}
