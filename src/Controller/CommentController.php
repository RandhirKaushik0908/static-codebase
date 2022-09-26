<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentController extends AbstractController
{


    #[Route('/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $time = new DateTime();
            $comment->setDateOfComment($time);
            $comment->setNumOfReplies(0);

            // create a new comment, entity manager
            $entityManager = $doctrine->getManager();
            // tell doctrine to save comment
            $entityManager->persist($comment);
            // actually execute the queries
            $entityManager->flush();

            return $this->redirect($this->generateUrl('homepage'));

        }

        return $this->render('comment/create_form.html.twig', [
            'form'=> $form->createView()
    ]);
    }

}