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

class AdminController extends Controller
{
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
                $billet->setPublished($billetModel->getPublished());
                $em->persist($billet);
                $em->flush();

                return $this->redirectToRoute('blogjf_admin', array());
            }
        }
        return $this->render('BlogJFBlogBundle:Admin:add.html.twig', array(
        'form' => $form->createView(),
        ));
    }

    public Function adminshowAction(Billet $billet, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $billetModel = new BilletModel();
        $billetModel->setId($billet->getId());
        $billetModel->setTitre($billet->GetTitre());
        $billetModel->setRoman($billet->getRoman());
        $billetModel->setPublished($billet->getPublished());
        $form = $this->get('form.factory')->create(BilletType::class, $billetModel);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
            $billet = new Billet();
            $billet->setId($billetModel->getId());
            $billet->setTitre($billetModel->getTitre());
            $billet->setRoman($billetModel->getRoman());
            $billet->setPublished($billetModel->getPublished());
            $em->merge($billet);
            $em->flush();
            return $this->redirectToRoute('blogjf_admin', array());
            }
        }

        return $this->render('BlogJFBlogBundle:Admin:adminshow.html.twig', array(
        'billet' => $billet,
        'form' => $form->createView()
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

    public function adminCommentAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('BlogJFBlogBundle:Commentaire')->findBy(
            array('signaler' => true),
            array('billet' => 'ASC')
        );

        return $this->render('BlogJFBlogBundle:Admin:CommentSignaler.html.twig', array(
            'commentaires' => $commentaires
        ));

    }

    public function adminDelCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('BlogJFBlogBundle:Commentaire')->find($id);
        if (null === $commentaire) {
            throw new NotFoundHttpException("Le commentaire ".$id." n'existe pas.");
        }

        $em->remove($commentaire);
        $em->flush();

        $this->addFlash('info', "Le commentaire a bien été supprimée.");
        return $this->redirectToRoute('blogjf_admincomment');
    }

    public function adminOkCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository('BlogJFBlogBundle:Commentaire')->find($id);

        if (null === $commentaire) {
            throw new NotFoundHttpException("Le commentaire ".$id." n'existe pas.");
        }

        $commentaire->setSignaler(false);
        $em->merge($commentaire);
        $em->flush();

        //return $this->redirectToRoute('blogjf_admin');
        return $this->redirectToRoute('blogjf_admincomment');
    }
}