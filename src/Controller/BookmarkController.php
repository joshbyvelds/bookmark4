<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Bookmark;
use App\Form\BookmarkType;
use App\Repository\BookmarkRepository;

use Symfony\Component\String\Slugger\SluggerInterface;

class BookmarkController extends AbstractController
{
    #[Route('/bookmark', name: 'app_bookmark')]
    public function index(): Response
    {


        return $this->render('bookmark/index.html.twig', [

        ]);
    }

    #[Route('/bookmark/add', name: 'app_bookmark_add')]
    public function add(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $bookmark = new Bookmark();
        $date = new \DateTime();
        $bookmark->setLastVisit($date);
        $bookmark->setCreated($date);
        $bookmark->setClicks(0);
        $bookmark->setFavorite(false);
        $bookmark->setUser($user);
        $form = $this->createForm(BookmarkType::class, $bookmark);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $data = $form->getData();
            $iconFile = $form->get('icon_file')->getData();
            $bgFile = $form->get('bg_image_file')->getData();

            // Validate here if needed..

            // Transform form data if needed..
            if ($iconFile) {
                $originalFilename = pathinfo($iconFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$iconFile->guessExtension();

                try {
                    $iconFile->move(
                        $this->getParameter('bookmark_icons_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $bookmark->setIcon($newFilename);
            }

            if ($bgFile) {
                $originalFilename = pathinfo($bgFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$bgFile->guessExtension();

                try {
                    $bgFile->move(
                        $this->getParameter('bookmark_backgrounds_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $bookmark->setBgImage($newFilename);
            }

            // Shove form data into database table.

            $em = $doctrine->getManager();
            $em->persist($bookmark);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('bookmark/form.html.twig', [
            'action' => 'Add New',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/bookmark/edit/{id}', name: 'app_bookmark_edit')]
    public function edit(BookmarkRepository $booksRepo, ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, $id): Response
    {
        $bookmark = $booksRepo->find($id);
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $data = $form->getData();
            $iconFile = $form->get('icon_file')->getData();
            $bgFile = $form->get('bg_image_file')->getData();

            // Validate here if needed..

            // Transform form data if needed..
            if ($iconFile) {
                $originalFilename = pathinfo($iconFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$iconFile->guessExtension();

                try {
                    $iconFile->move(
                        $this->getParameter('bookmark_icons_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $bookmark->setIcon($newFilename);
            }

            if ($bgFile) {
                $originalFilename = pathinfo($bgFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$bgFile->guessExtension();

                try {
                    $bgFile->move(
                        $this->getParameter('bookmark_backgrounds_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $bookmark->setBgImage($newFilename);
            }

            // Shove form data into database table.
            $em = $doctrine->getManager();
            $em->persist($bookmark);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('bookmark/form.html.twig', [
            'action' => 'Edit',
            'form' => $form->createView(),
        ]);
    }
}
