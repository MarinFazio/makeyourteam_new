<?php

namespace MYT\MakeYourTeamBundle\Controller;

use MYT\MakeYourTeamBundle\Entity\Annonce;
use MYT\MakeYourTeamBundle\Entity\Image;
use MYT\MakeYourTeamBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $em->getRepository('MakeYourTeamBundle:Annonce');

//        $annonce = $annonceRepository->find(8);

//        $listCompetenceAnnonce = $em->getRepository("MakeYourTeamBundle:AnnonceCompetence")->findBy(array('annonce' => $annonce));

        $annonces = $annonceRepository->findAll();

        $user = $this->getUser();

        $csrfToken = $this->has('form.csrf_provider')
            ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
            : null;

        return $this->render("MakeYourTeamBundle:Public:index.html.twig", array(
            'annonces'               => $annonces,
            'user'                   => $user,
            'csrf_token'             => $csrfToken,
//            'listCompetenceAnnonce' => $listCompetenceAnnonce,
        ));
    }


}
