<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class DefaultControllerTest extends WebTestCase
{
    public function testHomepage(): void
    {
        $this->login();
        self::$client->request('GET', '/');
        $this->assertTrue(self::$client->getResponse()->isOk());
    }
}
