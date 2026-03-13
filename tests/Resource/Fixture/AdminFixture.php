<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixture extends Fixture
{
    public const string REFERENCE_NAME = 'admin_user';

    public function __construct(private readonly UserFactory $userFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->create('test@test.com', 'test1234');

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE_NAME, $user);
    }
}
