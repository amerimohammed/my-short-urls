<?php

namespace App\Controller;

use App\Entity\Url;
use App\Entity\User;
use App\Form\UrlFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/url')]
class UrlController extends AbstractController
{
    private $entityManager;
    private $urlRepository;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->urlRepository = $entityManager->getRepository(Url::class);
    }

    #[Route('/', name: 'app_url_index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('url/index.html.twig', [
          'urls' => $this->urlRepository->findAll()  
        ]);
    }

    #[Route('/new', name:'app_url_new', methods:['GET', 'POST'])]
    public function new(Request $request) : Response
    {   
        $url = new Url();
        $form = $this->createForm(UrlFormType::class, $url);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $url->setShortUrl(uniqid());
            $url->setVisitedTimes(0);
            $this->entityManager->persist($url);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_url_index');
        }

        return $this->render('url/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/edit/{shortUrl}', name:'app_url_edit', methods:['GET', 'POST'])]
    public function edit($shortUrl, Request $request) : Response
    {   
        $url = $this->urlRepository->findOneBy(['shortUrl' => $shortUrl]);

        if($url ) {
            $form = $this->createForm(UrlFormType::class, $url);
    
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->flush();
                return $this->redirectToRoute('app_url_index');
            }
    
            return $this->render('url/edit.html.twig', [
                'form' => $form
            ]);
        }

        return new Response("Not found!", 404);
    }

    #[Route('/delete/{shortUrl}', name:'app_url_delete', methods:['POST'])]
    public function delete($shortUrl, Request $request) : Response
    {   
        $url = $this->urlRepository->findOneBy(['shortUrl' => $shortUrl]);

        if($url) {
            if ($this->isCsrfTokenValid('delete'.$url->getShortUrl(), $request->request->get('_token'))) {
                $this->entityManager->remove($url);
                $this->entityManager->flush();
            }
        }

        return $this->redirectToRoute('app_url_index');
    }
}
