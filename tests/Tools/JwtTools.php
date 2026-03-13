<?php

declare(strict_types=1);

namespace App\Tests\Tools;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait JwtTools
{
    use FixtureTools;

    private string $token = '' {
        get {
            return $this->token;
        }
    }

    private string $refreshToken = '' {
        get {
            return $this->refreshToken;
        }
    }

    private function setAuthTokens(KernelBrowser $client): void
    {
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
        $this->token = $data['token'];
        $this->refreshToken = $data['refresh_token'];
    }
}
