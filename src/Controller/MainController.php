<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private CommentRepository $commentRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    #[Route('/', name: 'homepage')]
    public function index(Request $request, PaginatorInterface $paginator, ManagerRegistry $doctrine): Response
    {
        $doctrine->getManager();
        $comments = $this->commentRepository->findAll();
        $allPagesQuery = $this->commentRepository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();
        $pages = $paginator->paginate(
            $allPagesQuery, $request->query->getInt('page', 1),
            10
        );
        return $this->render('comment/index.html.twig', [
            'comments'=> $comments,
            'pages'=>$pages
        ]);
    }

//    #[Route('/comments/{page}', name: 'comments_list')]
//    public function getUsersByPage($page = 1){
////        build the query for the doctrine paginator
//        $paginatorQuery = $this->commentRepository->createQueryBuilder('page')
//            ->orderBy('comments.id', 'DESC')
//            ->getQuery();
//
//        $perPage = '10';
//        $paginator = new Paginator($paginatorQuery);
//        $totalComments = count($paginator);
//        $pageCount = ceil($totalComments/$perPage);
//
//       $paginator
//           ->getQuery()
//           ->setFirstResult($perPage * ($paget-1))
//           ->setMaxResults($perPage);
//       foreach ($paginator as $pageItem){
//
//       }
//    }

    /**
     * @param $id
     * @param CommentRepository $commentRepository
     * @return Response
     */
    #[Route('/display/{id}', name: 'display')]
    public function display($id, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->findByCategory($id);

        //create the comment display view
        return $this->render('comment/_comment.html.twig', [
            'comment'=> $comment,
        ]);
    }
    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/comment/view/{comment_number?}', name: 'view')]
    public function viewComment(Request $request): Response
    {
        var_dump($request->get('comment_number'));
        return $this->render('comment/view.html.twig', [
        'controller_name' => 'MainController',
    ]);
    }


    #[Route('/', name: 'home')]
    public function home_custom(): Response{
        return new Response(content: '<h1> Welcome! </h1>');
    }
}
