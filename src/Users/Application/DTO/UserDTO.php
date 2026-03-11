<?php
declare(strict_types=1);

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;

readonly class UserDTO
{
    public function __construct(
        public string $ulid,
        public string $email,
    )
    {
    }

    public static function fromEntity(User $user): UserDTO
    {
        return new self(
            $user->getUlid(),
            $user->getEmail(),
        );
    }
}
