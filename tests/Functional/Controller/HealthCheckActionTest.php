<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HealthCheckActionTest extends WebTestCase
{
    public function testRequestResponseSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/healthcheck');

        $this->assertResponseIsSuccessful();
        $jsonResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('ok', $jsonResult['status']);
    }
}
