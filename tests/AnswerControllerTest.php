<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AnswerControllerTest extends WebTestCase
{
    private $client = null;
    
    public function setUp()
    {
        $this->client = static::createClient();
    }

    private function logIn($userName, $userRole){
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($userName, null, $firewallName, $userRole);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * Check the logged-on user's path access with the ROLE_USER role
     */
    public function testSecuredRoleUser()
    {
        $this->logIn('User', ['ROLE_USER']);
        $crawler = $this->client->request('GET', '/answer/');
        
        // Asserts that /answer/new path exists and don't return an error
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());
    }

     /**
     * Check the logged-on user's path access with the ROLE_ADMIN role
     */
    public function testSecuredRoleAdmin()
    {
        $this->logIn('Admin', ['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/answer/new');

        // Asserts that /answer/new path exists and don't return an error
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        
        // Asserts that the response content contains 'Create new Answer' in 'h1' tag
        $this->assertSelectorTextContains('html body h1', 'Create new Answer');
    }
}
