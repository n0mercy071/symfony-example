<?php
declare(strict_types=1);

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\Tools\FixtureTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetMeActionTest extends WebTestCase
{
    use FixtureTools;

    public function testGetMeAction(): void
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();

        $client->request(
            'POST',
            '/api/auth/token/login',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ]),
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $data['token']));

        //act
        $client->request('GET', '/api/users/me');
        $data = json_decode($client->getResponse()->getContent(), true);

        //assert
        $this->assertEquals($user->getEmail(), $data['email']);
        $this->assertEquals($user->getUlid(), $data['ulid']);
    }
}
