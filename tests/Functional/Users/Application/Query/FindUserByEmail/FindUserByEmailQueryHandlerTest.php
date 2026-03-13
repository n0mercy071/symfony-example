<?php

declare(strict_types=1);

namespace App\Tests\Functional\Users\Application\Query\FindUserByEmail;

use App\Shared\Application\Query\QueryBusInterface;
use App\Tests\Resource\Fixture\UserFixture;
use App\Users\Application\DTO\UserDTO;
use App\Users\Application\Query\FindUserByEmail\FindUserByEmailQuery;
use App\Users\Domain\Entity\User;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FindUserByEmailQueryHandlerTest extends WebTestCase
{
    private QueryBusInterface $queryBus;
    private AbstractDatabaseTool $databaseTool;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryBus = $this->getContainer()->get(QueryBusInterface::class);
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testUserCreatedWhenCommandExecuted(): void
    {
        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
        $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE_NAME, User::class);
        $query = new FindUserByEmailQuery($user->getEmail());

        $userDTO = $this->queryBus->execute($query);

        $this->assertInstanceOf(UserDTO::class, $userDTO);
    }
}
