<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;


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
}
