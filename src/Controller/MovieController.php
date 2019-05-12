<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Tmdb\ApiToken;
use Tmdb\Client;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie/{id}", name="movie")
     */
    public function show_movie($id)
    {
        $token  = new ApiToken('3e4cea52f066f23b2d8bc78bf6f82d40');
        $client = new Client($token);
        $movie = $client->getMoviesApi()->getMovie($id, [
            'language' => 'fr'
        ]);
        $credits = $client->getMoviesApi()->getCredits($id, [
            'language' => 'fr'
        ]);
        $trailers = $client->getMoviesApi()->getTrailers($id, [
            'language' => 'fr'
        ]);

        dump($movie);
        dump($credits);
        dump($trailers);

        return $this->render('movie/show_movie.html.twig', [
            'movie' => $movie,
            'credits' => $credits,
            'trailers' => $trailers
        ]);

    }
}
