<?php
namespace CO\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CO\ArticlesBundle\Entity\Comment;
use CO\ArticlesBundle\Form\CommentType;

class CommentController extends Controller
{
	
    /**
     * @Template()
     */
    public function formAction($article_id)
    {
        $article = $this->getBlog($article_id);

        $comment = new Comment();
        $comment->setArticle($article);
        $form   = $this->createForm(new CommentType(), $comment);

        return array(
            'comment' => $comment,
            'form'   => $form->createView()
        );
    }

    /**
     * @Route("/comment/{id}", requirements={"method"="GET", "id"="\d+"}, name="_create_comment")
     * @Template()
     */
    public function createAction($id)
    {
        $article = $this->getBlog($id);

        $comment  = new Comment();
        $comment->setArticle($article);
        $request = $this->getRequest();
        $form    = $this->createForm(new CommentType(), $comment);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('_show_article', array(
                'id' => $comment->getArticle()->getId(),
                'slug' => $comment->getArticle()->getSlug() )) .
                '#comment-' . $comment->getId()
            );
        }

        return array(
            'comment' => $comment,
            'form'    => $form->createView()
        );
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('COArticlesBundle:Article')->find($blog_id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $article;
    }	
}

