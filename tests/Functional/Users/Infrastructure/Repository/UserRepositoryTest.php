<?php
declare(strict_types=1);

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Resource\Fixture\AdminFixture;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    private UserRepository $repository;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;
    private UserFactory $userFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getContainer()->get(UserRepository::class);
        $this->userFactory = $this->getContainer()->get(UserFactory::class);
        $this->faker = Factory::create();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testUserAddedSuccessfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $user = $this->userFactory->create($email, $password);

        $this->repository->add($user);

        $existingUser = $this->repository->findByUlid($user->ulid);
        $this->assertEquals($user->ulid, $existingUser->ulid);
    }

    public function testUserFoundSuccessfully(): void
    {
        $executor = $this->databaseTool->loadFixtures([AdminFixture::class]);
        $user = $executor->getReferenceRepository()->getReference(AdminFixture::REFERENCE_NAME, User::class);

        $foundUser = $this->repository->findByUlid($user->getUlid());

        $this->assertEquals($user->getUlid(), $foundUser->ulid);
    }
}
