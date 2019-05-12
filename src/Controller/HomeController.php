<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Tmdb\ApiToken;
use Tmdb\Client;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $token  = new ApiToken('3e4cea52f066f23b2d8bc78bf6f82d40');
        $client = new Client($token);
        $movie = $client->getMoviesApi()->getUpcoming([
            'language' => 'fr'
        ]);

        return $this->render('home/index.html.twig', [
            'movies' => $movie
        ]);
    }

}
