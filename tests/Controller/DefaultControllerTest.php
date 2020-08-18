<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class DefaultControllerTest extends WebTestCase
{
    public function testHomepage(): void
    {
        self::login();
        self::$client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }
}
