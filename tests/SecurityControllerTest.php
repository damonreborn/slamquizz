<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }
    
     /**
     * Login form show username, password and submit button
     */
    public function testShowLogin()
    {
        // Request /login 
        //$this->client->request('GET', '/login');
        $crawler = $this->client->request('GET', '/login');

        // Asserts that /login path exists and don't return an error
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        
        // Asserts that the phrase "Log in!" is present in the page's title
        
        $this->assertSelectorTextContains('html head title', 'Log in!');


        // Asserts that the response content contains 'csrf token'
        //$this->assertCount(1, $crawler->filter( '<input type="hidden" name="_csrf_token">'));
        $this->assertContains(
            '_csrf_token',
            $this->client->getResponse()->getContent()
        );

        // Asserts that the response content contains 'input type="text" id="inputEmail"'
        $this->assertContains(
            '<input type="text" value="" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>',
            $this->client->getResponse()->getContent()
        );

        
        // Asserts that the response content contains 'input type="text" id="inputPassword"'
        $this->assertContains(
            '<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>',
            $this->client->getResponse()->getContent()
        );
        
    }

     /**
     * Verify that the category list is not displayed to users who do not have the admin role
     */
    public function testNotShowCategory()
    {
        // Request /category 
        $this->client->request('GET', '/category/new');

        // Asserts that category path move to another path (login)
        $this->assertTrue(
            $this->client->getResponse()->isRedirect('/login'));
        
        // Vérifie que le code HTTP renvoyé est "302" ou "HTTP_FOUND". 
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        
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

    public function testSecuredRoleUser()
    {
        $this->logIn('User', ['ROLE_USER']);
        $crawler = $this->client->request('GET', '/category/');
        
        // Asserts that /category path exists and don't return an error
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        
        // Asserts that the response content contains 'Category index' in 'head title' tag
        $this->assertSelectorTextContains('html body h1', 'Category index');
        
        $crawler = $this->client->request('GET', '/category/new');

        // Asserts that /category/new path exists return an error for the Access
        $this->assertEquals(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());

    }

    public function testSecuredRoleAdmin()
    {
        $this->logIn('Admin', ['ROLE_ADMIN']);
        $crawler = $this->client->request('GET', '/category/new');

        // Asserts that /category/new path exists and don't return an error
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        
        // Asserts that the response content contains 'Create new category' in 'h1' tag
        $this->assertSelectorTextContains('html body h1', 'Create new Category');
    }
    }
