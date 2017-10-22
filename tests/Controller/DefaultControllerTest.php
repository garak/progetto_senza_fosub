<?php

namespace Tests\Controller;

/**
 * @group functional
 */
class DefaultControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $this->login();
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isOk());
    }
}
