<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminAlimentController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/aliment', name: 'admin_aliment')]
    public function index(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin_aliment/adminAliments.html.twig', [
            'aliments' => $aliments,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/aliment/{id}/delete', name: 'admin_aliment_delete', methods:['DELETE'])]
    public function delete(Aliment $aliment, Request $request, EntityManagerInterface $entityManagerInterface ): Response
    {
        if ($this->isCsrfTokenValid("SUP".$aliment->getId(), $request->get('_token'))){
            $entityManagerInterface->remove($aliment);
            $entityManagerInterface->flush();
            return $this->redirectToRoute("admin_aliment");
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/aliment/create', name : 'admin_aliment_create')]
    #[Route('/admin/aliment/{id}', name: 'admin_aliment_modify', methods:['GET','POST'])]
    public function modifyOrCreate(Aliment $aliment = null,SluggerInterface $slugger , Request $request, EntityManagerInterface $entityManagerInterface ): Response
    {
        if(!$aliment){
           $aliment = new Aliment;
        }
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();

            if ($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('upload_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'upload_dir' property to store the PDF file name
                // instead of its contents
                $aliment->setImage('aliments/'.$newFilename);
            }
            // dd($form->get('image')->getData());
            $entityManagerInterface->persist($aliment);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('admin_aliment');
        }

        return $this->render('admin_aliment/adminAlimentModify.html.twig', [
            'aliment' => $aliment,
            'form' => $form->createView(),
        ]);
    }

}
