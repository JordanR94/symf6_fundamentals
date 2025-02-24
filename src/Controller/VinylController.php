<?php

namespace App\Controller;

use App\Service\MixRepository;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    public function __construct(
        private bool $isDebug,
        private MixRepository $mixRepository,
    ){}

    #[Route('/', name: 'app_homepage')]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(string $slug = null): Response
    {
        dump($this->isDebug);
        //dump($cache);
        //dd($this->getParameter('kernel.project_dir'));
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;

        $mixes = $this->mixRepository->findAll();

        //use DateTimeFormatter for this code (no longer needed)
        //     foreach ($mixes as $key => $mix){
        //        $mixes[$key]['ago'] = $timeFormatter->formatDiff($mix['createdAt']);
        //     }

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }
}
