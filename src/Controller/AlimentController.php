<?php

namespace App\Controller;

use App\Entity\Aliment;
use App\Entity\AlimentLike;
use App\Repository\AlimentLikeRepository;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class AlimentController extends AbstractController
{
    #[Route('/', name: 'aliments')]
    public function index(AlimentRepository $repository, Request $request): Response
    {
        //on recupere les filtres (categories)
        $filtres = $request->get("category");
        $totalAliments = $repository->findAll();
        $aliments = $repository->getAlimentsByCategory($filtres);

        if ($request->get('ajax')){
          return new JsonResponse([
              'content' => $this->renderView('aliment/json.html.twig', [
                "aliments" => $aliments,
                "totalAliments" => $totalAliments,
                "isCalorie" => false,
            ])
          ]);
        }

        return $this->render('aliment/aliments.html.twig', [
            "aliments" => $aliments,
            "totalAliments" => $totalAliments,
            "isCalorie" => false,
        ]);
    }

    #[Route('/aliment/show/{id}', name: 'show_aliment')]
    public function show(Aliment $aliment = null): Response
    {
        if(!isset($aliment)){
            return $this->render('error/error_404.html.twig', [
                'controller_name' => 'AlimentController',
            ]);
        } else {
            return $this->render('aliment/aliment.html.twig', [
                'aliment' => $aliment,
            ]);
        }
    }

    #[Route('/aliments/calorie/{calorie}', name: 'alimentsCalories')]
    public function alimentParCalorie(AlimentRepository $repository, $calorie): Response
    {
        $totalAliments = $repository->findAll();
        $aliments = $repository->getAlimentsParNbreCalories('calorie', '<', $calorie);
        return $this->render('aliment/aliments.html.twig', [
            'controller_name' => 'AlimentController',
            'totalAliments' => $totalAliments,
            "aliments" => $aliments,
            "isCalorie" => true,
        ]);
    }

    #[Route('/aliments/glucide/{glucide}', name: 'alimentsGlucide')]
    public function alimentParGlucide(AlimentRepository $repository, $glucide): Response
    {
        $totalAliments = $repository->findAll();
        $aliments = $repository->getAlimentsParNbreCalories('glucide', '<', $glucide);
        return $this->render('aliment/aliments.html.twig', [
            'controller_name' => 'AlimentController',
            "aliments" => $aliments,
            'totalAliments' => $totalAliments,
            "isCalorie" => true,
        ]);
    }

    #[Route('/{id}/like', name: 'aliments_like')]
    public function like(
        AlimentLikeRepository $alimentLike, 
        Aliment $aliment, 
        EntityManagerInterface $manager,
        Request $request
    ): Response
    {   
        $user = $this->getUser();
        
        //si il n'y a pas de user connecté alors erreur 403 aunauthorized
        if (!$user) {
            //on peut aussi renvoyer vers une page d'erreur 403
            return $this->json([
                'code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }

        //si l'aliment est déjà aimé alors on supprime le like
        if ($aliment->isLikeByUser($user)) {
            $like = $alimentLike->findOneBy([
                'aliment' => $aliment,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'image' => 'images/pouce_blanc.png',
                'message' => 'Like bien supprimé',
                'text' => "j'aime !",
                'likes' => $alimentLike->count(['aliment' => $aliment])
            ], 200);

            if ($request->get('ajax')){
                return $this->json([
                    'code' => 200,
                    'image' => 'images/pouce_blanc.png',
                    'message' => 'Like bien supprimé',
                    'text' => "j'aime !",
                    'likes' => $alimentLike->count(['aliment' => $aliment])
                ], 200);
            }
        } 

        $like = new AlimentLike();
        $like->setAliment($aliment)
            ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200, 
            'message' => 'like bien ajouté !',
            'image' => 'images/pouce_noir.png',
            'text' => "je n'aime plus ?",
            'likes' => $alimentLike->count(['aliment' => $aliment])
        ], 200);
    }



}
