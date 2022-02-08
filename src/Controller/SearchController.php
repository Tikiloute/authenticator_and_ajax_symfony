<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('aliment/search', name: 'search')]
    public function index(Request $request, AlimentRepository $alimentRepository): Response
    {
        $result = $request->query->get('search');
        $aliments = $alimentRepository->findBySearch($result);
        return $this->render('search/resultSearch.html.twig', [
            'result' => $result,
            'aliments' => $aliments,
        ]);
    }
}
