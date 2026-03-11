<?php
declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use App\Users\Infrastructure\UserPasswordHasher;

class User implements AuthUserInterface
{
    public string $ulid;
    public string $email;
    private ?string $password = null;

    public function __construct(string $email)
    {
        $this->ulid = UlidService::generate();
        $this->email = $email;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password, UserPasswordHasher $passwordHasher): void
    {
        if (is_null($password)) {
            $this->password = null;
            return;
        }

        $this->password = $passwordHasher->hash($this, $password);
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getUserIdentifier(): string
    {
         return $this->email;
    }
}
