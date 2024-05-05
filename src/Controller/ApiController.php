<?php

namespace App\Controller;

use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/decode/{shortUrl}', name: 'app_api')]
    public function decodeUrl($shortUrl, UrlRepository $urlRepository, EntityManagerInterface $entityManager): Response
    {   
        $url = $urlRepository->findOneBy(['shortUrl' => $shortUrl]);
        if($url) {
            $url->setVisitedTimes($url->getVisitedTimes() + 1);
            $entityManager->flush($url);
            return $this->json([
                'originalUrl' => $url->getLongUrl()]
            );
        }

        return $this->json(['error' => 'Url Not found'], 404);
    }
}
