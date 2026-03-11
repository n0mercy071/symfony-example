<?php
declare(strict_types=1);

namespace App\Users\Infrastructure\Console;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'app:users:create',
    description: 'Create a user',
)]
final class CreateUser extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private UserFactory $userFactory,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('email', null, function (string $email): string {
            Assert::email($email, 'Email is not valid.');

            return $email;
        });

        $password = $io->ask('password', null, function (string $password): string {
            Assert::notEmpty($password, 'Password should not be empty.');

            return $password;
        });

        $user = $this->userFactory->create($email, $password);
        $this->userRepository->add($user);

        return Command::SUCCESS;
    }
}
