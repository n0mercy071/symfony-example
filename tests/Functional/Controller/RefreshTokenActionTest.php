<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Tests\Tools\JwtTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RefreshTokenActionTest extends WebTestCase
{
    use JwtTools;

    public function testRefreshTokenActionSuccessfully(): void
    {
        $client = static::createClient();
        $this->setAuthTokens($client);

        // act
        $client->request('POST', '/api/auth/token/refresh',
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: json_encode([
                'refresh_token' => $this->refreshToken,
            ]),
        );
        $data = json_decode($client->getResponse()->getContent(), true);

        // assert
        $this->assertResponseIsSuccessful();
        $this->assertNotEmpty($data['token']);
        $this->assertNotEmpty($data['refresh_token']);
    }
}
