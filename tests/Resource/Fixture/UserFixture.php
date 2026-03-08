<?php

namespace App\Tests\Resource\Fixture;

use App\Tests\Tools\FakerTools;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerTools;

    public const string REFERENCE_NAME = 'user';

    public function load(ObjectManager $manager): void
    {
        $email = self::getFaker()->email();
        $password = self::getFaker()->password();
        $user = new UserFactory()->create($email, $password);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE_NAME, $user);
    }
}
