<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AcceptType;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/comment")
 */

class CommentAdminController extends AbstractController
{
    /**
     * @Route("/", name="comment_admin")
     */
    public function index(
        CommentRepository $commentRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $pagination = $paginator->paginate(
            $commentRepository->findBy(
                [],
                ['accepted'=>'ASC', 'postDate'=>'DESC']
            ),
            $request->query->getInt('page', 1),
            $this->getParameter('elements_by_page')
        );
        return $this->render('comment_admin/index.html.twig', [
            'comments' => $pagination
        ]);
    }

    /**
     * @Route("/{id}", name="comment_admin_show", methods="GET|POST")
     */
    public function show(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(AcceptType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAccepted(!$comment->getAccepted());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_admin', ['id' => $comment->getId()]);
        }

        return $this->render('comment_admin/show.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_admin_delete", methods="DELETE")
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();

            $this->addFlash('success', 'Le commentaire a bien été supprimé');
        }

        return $this->redirectToRoute('comment_admin');
    }
}
