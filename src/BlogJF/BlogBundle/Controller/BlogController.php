<?php

namespace BlogJF\BlogBundle\Controller;

use BlogJF\BlogBundle\Entity\Billet;
use BlogJF\BlogBundle\Entity\Commentaire;
use BlogJF\BlogBundle\Form\BilletEditType;
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
            throw $this->createNotFoundException('Impossible d ouvrir cet épisode');
        }

        $commentaires = $em->getRepository('BlogJFBlogBundle:Commentaire')
                           ->getCommentaireById($billet->getId());

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
                $em->persist($commentaire);
                $em->flush();
                $this->addFlash('success', 'Merci pour votre commentaire :)');
                /*return $this->redirectToRoute('blogjf_show', array(
                    'billet' => $billet,
                    'commentaires' => $commentaires,
                    'form' => $form->createView()
                ));*/
            }
        }
        return $this->render('BlogJFBlogBundle:Blog:show.html.twig', array(
            'billet' => $billet,
            'commentaires' => $commentaires,
            'form' => $form->createView()
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
                if ($billet->getRoman() === null)
                {

                }
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
        $billet = $em->getRepository('BlogJFBlogBundle:Billet')->find($id);
        $billetModel = new BilletModel();
        $billetModel->setId($billet->getId());
        $billetModel->setTitre($billet->GetTitre());
        $billetModel->setRoman($billet->getRoman());
        $form = $this->get('form.factory')->create(BilletType::class, $billetModel);

        if ($request->isMethod('POST')) {
            dump($billetModel->getTitre());
            dump($billetModel->getRoman());
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
        //$commentaires = $em->getRepository('BlogJFBlogBundle:Commentaire')
        //    ->getCommentaireById($billetModel->getId());

        return $this->render('BlogJFBlogBundle:Admin:adminshow.html.twig', array(
            'billet' => $billet,
            'form' => $form->createView()
            //'commentaires' => $commentaires
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