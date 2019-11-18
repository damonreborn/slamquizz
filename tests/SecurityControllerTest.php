<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

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
        $this->client->request('GET', '/login');

        // Asserts that /login path exists and don't return an error
        /* 
        Ecrire ici le code pour valider le succès de la réponse HTTP,
        c'est à dire affirmer que le code de statut de la réponse est égale à 200 (Response::HTTP_OK)
        */
       
        
        // Asserts that the phrase "Log in!" is present in the page's title
        /* 
        Ecrire ici le code pour vérifier la présence de la phrase "Log in!" dans le titre de la page,
        c'est à dire affirmer qu'en parcourant le DOM, la balise 'html head title' contient 'Log in!'
        */ 


        // Asserts that the response content contains 'csrf token'
        /*
        Ecrire ici le code pour vérifier la présence du jeton csrf dans le contenu de la réponse HTTP  
        c'est à dire affirmer que le contenu de la réponse contient 'type="hidden" name="_csrf_token"'
        */

        
        // Asserts that the response content contains 'input type="text" id="inputEmail"'
        /*
        Ecrire ici le code pour vérifier la présence du champ de formulaire email dans le contenu de la réponse HTTP  
        c'est à dire affirmer que le contenu de la réponse contient '<input type="email" value="" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>'
        */

        
        // Asserts that the response content contains 'input type="text" id="inputPassword"'
        /*
        Ecrire ici le code pour vérifier la présence du champ de formulaire password dans le contenu de la réponse HTTP  
        c'est à dire affirmer que le contenu de la réponse contient '<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>'
        */
        
    }
}
