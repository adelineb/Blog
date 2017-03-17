<?php

namespace BlogJF\BlogBundle\Controller;

use BlogJF\BlogBundle\Entity\Billet;
use BlogJF\BlogBundle\Entity\Commentaire;
use BlogJF\BlogBundle\Form\BilletType;
use BlogJF\BlogBundle\Form\CommentaireType;
use BlogJF\BlogBundle\Model\BilletModel;
use BlogJF\BlogBundle\Model\CommentaireModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('BlogJFBlogBundle:Billet');
        $listeBillets = $repository->ListeByDateDESC();
        return $this->render('BlogJFBlogBundle:Blog:index.html.twig', array(
            'billets' => $listeBillets
        ));
    }

    public function aproposAction()
    {
        return $this->render('BlogJFBlogBundle:Blog:apropos.html.twig');
    }

    public Function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $billet = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);
        if (!$billet) {
            throw $this->createNotFoundException("Impossible d'ouvrir cet épisode");
        }

        $commentaires = $em->getRepository('BlogJFBlogBundle:Commentaire')
                           ->getCommentaireById($billet->getId());

        $commentModel = new CommentaireModel();
        $form = $this->get('form.factory')->create(CommentaireType::class, $commentModel);

        /*foreach($commentaires as $k => $commentaire) {
            if($commentaire->getParentId() != null) {
                unset($commentaires[$k]);
            }
        }*/
        dump($commentaires);

        return $this->render('BlogJFBlogBundle:Blog:show.html.twig', array(
            'billet' => $billet,
            'commentaires' => $commentaires,
            'form' => $form->createView()
        ));
    }

    public Function addAction($id, $parentid, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $billet = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);
        $commParent = $em->getRepository('BlogJFBlogBundle:Commentaire')->find($parentid);
        $commentModel = new CommentaireModel();
        $form = $this->get('form.factory')->create(CommentaireType::class, $commentModel);
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $commentaire = new Commentaire();
                $commentaire->setBillet($billet);
                $commentaire->setAuteur($commentModel->getAuteur());
                $commentaire->setCommentaire($commentModel->getCommentaire());

                $commentaire->addChildren($commentaire);
                if ($parentid === null)
                {
                    $commentaire->setParentId(null);
                }
                else
                {
                    $commentaire->setParentId($commParent);
                }

                $em->persist($commentaire);
                $em->flush();
                $this->addFlash('success', 'Merci pour votre commentaire :)');
            }
        };
        return $this->redirectToRoute('blogjf_show',array('id' => $id));
    }

    public Function signalerAction($idbillet, $idcomment)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('BlogJFBlogBundle:Commentaire')->find($idcomment);
        if ($comment->getSignaler() === false)
            $comment->setSignaler(true);
        else
            $comment->setSignaler(false);

        $em->merge($comment);
        $em->flush();
        return $this->redirectToRoute('blogjf_show',array('id' => $idbillet));
    }
}
