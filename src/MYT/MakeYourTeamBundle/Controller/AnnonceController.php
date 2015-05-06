<?php

namespace MYT\MakeYourTeamBundle\Controller;

use Doctrine\Common\Util\Debug;
use MYT\MakeYourTeamBundle\Entity\Annonce;
use MYT\MakeYourTeamBundle\Entity\AnnonceCompetence;
use MYT\MakeYourTeamBundle\Entity\Image;
use MYT\MakeYourTeamBundle\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnnonceController extends Controller
{

    public function addAction(Request $request)
    {
        $annonce = new Annonce();
        $form = $this->createForm(new AnnonceType(), $annonce);
        $user = $this->get('session')->get('user');

        $_request = $this->getRequest();
        if($_request->getMethod() == 'POST'){

            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();

//                $categorieRepository = $em->getRepository("MakeYourTeamBundle:Categorie");
                $categorie = $form->get('categorie')->getData();

                $annonce->setCategorie($categorie)->setAuteur('Auteur');

                $image = $form->getData()->getImage();
                $image->preUpload();
                //Le persist pour l'image est exécuté en cascade

                $annonce->setAuteur($user->getUsername());

                // On récupère toutes les compétences
                $listCompetence = $em->getRepository('MakeYourTeamBundle:Competence')->findAll();

                // Pour chaque compétence
                foreach ($listCompetence as $competence) {
                    // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
                    $annonceCompetence = new AnnonceCompetence();
                    // On la lie à l'annonce, qui est ici toujours la même
                    $annonceCompetence->setAnnonce($annonce);
                    // On la lie à la compétence, qui change ici dans la boucle foreach
                    $annonceCompetence->setCompetence($competence);
                    $annonceCompetence->setNiveau('Expert');
                    $em->persist($annonceCompetence);
                }
                $em->persist($annonce);
                $em->flush();

                $image->upload();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                return $this->redirect($this->generateUrl('home'));

            }
        }
        return $this->render("MakeYourTeamBundle:Annonce:add.html.twig", array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }

    public function editAction($slug, Request $request)
    {
        $user = $this->get('session')->get('user');
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $em->getRepository('MakeYourTeamBundle:Annonce');
        $annonce = $annonceRepository->findOneBySlug($slug);
        if($annonce === null){
            throw new NotFoundHttpException("L'annonce de slug $slug n'existe pas");
        }

        $form = $this->createForm(new AnnonceType(), $annonce);
        $form->handleRequest($request);
        if($form->isValid()){

            $image = $form->getData()->getImage();
            $image->preUpload();

            $em->flush();
            $image->upload();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirect($this->generateUrl('home'));
        }
        return $this->render("MakeYourTeamBundle:Annonce:edit.html.twig", array(
            'form' => $form->createView(),
            'user' => $user,
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository('MakeYourTeamBundle:Annonce')->find($id);
        $user = $this->get('session')->get('user');

        $form = $this->createFormBuilder()->getForm();
        $form->handleRequest($request);
        if($form->isValid()){
            $annonceCompetences = $em->getRepository('MakeYourTeamBundle:AnnonceCompetence')->findByAnnonce($annonce);
            foreach($annonceCompetences as $a){
                $em->remove($a);
            }

            $annonce->getImage()->preRemoveUpload();
            $em->remove($annonce);
            $em->flush();
            $annonce->getImage()->removeUpload();

            $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

            return $this->redirect($this->generateUrl('home'));
        }
        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('MakeYourTeamBundle:Annonce:delete.html.twig', array(
            'annonce' => $annonce,
            'form'    => $form->createView(),
            'user'    => $user,
        ));
    }

    public function showAction($slug){
        $em = $this->getDoctrine()->getManager();
        $annonce_repository = $em->getRepository('MakeYourTeamBundle:Annonce');
        $annonce = $annonce_repository->findOneBySlug($slug);
        if($annonce === null){
            throw new NotFoundHttpException("L'annonce de slug \"$slug\" n'existe pas");
        }

        $user = $this->get('session')->get('user');

        return $this->render('MakeYourTeamBundle:Annonce:show.html.twig', array(
            'annonce'       => $annonce,
            'user'          => $user,
        ));
    }

    public function pageAction($page)
    {
        return $this->render("MakeYourTeamBundle:Annonce:page.html.twig", array(
            'page' => $page,
        ));
    }

    public function articleAction()
    {
        $article = array(
            'titre'   => 'Titre de l\'article',
            'date'    => new \DateTime(),
            'contenu' => 'Contenu ici.',
            'auteur'  => 'Eric Dampierre',
        );

        return $this->render("MakeYourTeamBundle:Annonce:article.html.twig", array(
            'article' => $article,
        ));
    }

}