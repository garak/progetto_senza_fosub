<?php

namespace Tests\Controller;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;

/**
 * @group functional
 */
class AuthControllerTest extends WebTestCase
{
    public function testLoginErrore(): void
    {
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        self::$client->submit($form, [
            '_username' => 'nonexistant@foo.bar',
            '_password' => 'blablablah',
        ]);
        $crawler = self::$client->followRedirect();
        $this->assertTrue(self::$client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.alert-danger'));
    }

    public function testUtenteNonAttivo(): void
    {
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        self::$client->submit($form, [
            '_username' => 'daConfermare@example.com',
            '_password' => 'bellaperte',
        ]);
        $crawler = self::$client->followRedirect();
        $this->assertTrue(self::$client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.alert-danger:contains("non attivo")'));
    }

    public function testErroreGenericoInSessione(): void
    {
        $this->setSessionException();
        $crawler = self::$client->request('GET', '/login');
        $this->assertTrue(self::$client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filter('div.alert-danger:contains("errore...")'));
    }

    public function testLoginOk(): void
    {
        $crawler = self::$client->request('GET', '/login');
        $form = $crawler->filter('button[type="submit"]')->form();
        self::$client->submit($form, [
            '_username' => 'utente1@example.com',
            '_password' => 'ciaone',
        ]);
        $crawler = self::$client->followRedirect();
        $this->assertTrue(self::$client->getResponse()->isOk());
        $this->assertCount(0, $crawler->filter('div.alert-danger'));
    }

    public function testUtenteAutenticatoNonPuoVedereLogin(): void
    {
        $this->login();
        self::$client->request('GET', '/login');
        $this->assertTrue(self::$client->getResponse()->isRedirect());
    }

    private function setSessionException(): void
    {
        $session = static::$container->get('session');
        $session->set('_security.last_error', new AuthenticationServiceException('errore...'));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        self::$client->getCookieJar()->set($cookie);
    }
}
