<?php

namespace BlogJF\BlogBundle\Controller;

use BlogJF\BlogBundle\Entity\Billet;
use BlogJF\BlogBundle\Form\BilletEditType;
use BlogJF\BlogBundle\Form\BilletType;
use BlogJF\BlogBundle\Model\BilletModel;
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

    public Function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $billet = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);
        if (!$billet) {
            throw $this->createNotFoundException('Impossible d ouvrir cet épisode');
        }

        $commentaires = $em->getRepository('BlogJFBlogBundle:Commentaire')
                           ->getCommentaireById($billet->getId());

        /*$comments_id = [];
        foreach ($commentaires as $commentaire) {
            $comments_id[$commentaire->getCommentaire()] = $commentaire;
        }

        foreach ($commentaires as $k => $commentaire) {
            if ($commentaire->getId() <> 0) {
                $comments_id[$commentaire->getId()]->children[] = $commentaire;
                unset($commentaires[$k]);
            }
        }
        dump($comments_id);*/

        return $this->render('BlogJFBlogBundle:Blog:show.html.twig', array(
            'billet' => $billet,
            'commentaires' => $commentaires
        ));
    }

    public function adminAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('BlogJFBlogBundle:Billet');
        $listeBillets = $repository->ListeByDateDESC();
        return $this->render('BlogJFBlogBundle:Admin:admin.html.twig', array(
            'billets' => $listeBillets
        ));
    }
    public function adminAddAction(Request $request)
    {
        $billetModel = new BilletModel();
        $form = $this->get('form.factory')->create(BilletType::class, $billetModel);

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $billet = new Billet();
                $billet->setTitre($billetModel->getTitre());
                $billet->setRoman($billetModel->getRoman());
                $em->persist($billet);
                $em->flush();

                return $this->redirectToRoute('blogjf_admin', array());
            }
        }
        return $this->render('BlogJFBlogBundle:Admin:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public Function adminshowAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $billetModel = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);
        if (!$billetModel) {
            throw $this->createNotFoundException('Impossible d ouvrir cet épisode');
        }
        dump($billetModel);
        $form = $this->get('form.factory')->create(BilletType::class, $billetModel);
        dump($billetModel);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $billet = new Billet();
                $billet->setId($billetModel->getId());
                $billet->setTitre($billetModel->getTitre());
                $billet->setRoman($billetModel->getRoman());
                $em->merge($billet);
                $em->flush();
                return $this->redirectToRoute('blogjf_admin', array());
            }
        }
        $commentaires = $em->getRepository('BlogJFBlogBundle:Commentaire')
            ->getCommentaireById($billetModel->getId());

        return $this->render('BlogJFBlogBundle:Admin:adminshow.html.twig', array(
            'billet' => $billetModel,
            'form' => $form->createView(),
            'commentaires' => $commentaires
        ));
    }

    public Function adminDelAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $billet = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);

        if (null === $billet) {
            throw new NotFoundHttpException("L'épisode ".$id." n'existe pas.");
        }

        $em->remove($billet);
        $em->flush();
        $this->addFlash('info', "L'annonce a bien été supprimée.");
        return $this->redirectToRoute('blogjf_admin');
    }

    public Function adminUpdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $billet = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);

        if (null === $billet) {
            throw new NotFoundHttpException("L'épisode ".$id." n'existe pas.");
        }

        $em->remove($billet);
        $em->flush();
        $this->addFlash('info', "L'annonce a bien été supprimée.");
        return $this->redirectToRoute('blogjf_admin');
    }
}