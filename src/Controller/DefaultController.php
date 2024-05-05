<?php

namespace App\Controller;

use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->redirectToRoute("app_url_index");
    }

    #[Route('/redirect/{shortUrl}', name: 'app_redirect')]
    public function Urlredirect($shortUrl, UrlRepository $urlRepository, EntityManagerInterface $entityManager): Response
    {
        $url = $urlRepository->findOneBy(['shortUrl' => $shortUrl]);
        if($url) {
            $url->setVisitedTimes($url->getVisitedTimes() + 1);
            $entityManager->flush($url);
            return $this->redirect($url->getLongUrl());
        }    
        return new Response("Not found!", 404);
    }
}
