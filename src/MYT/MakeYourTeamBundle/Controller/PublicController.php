<?php

namespace MYT\MakeYourTeamBundle\Controller;

use MYT\MakeYourTeamBundle\Entity\Annonce;
use MYT\MakeYourTeamBundle\Entity\Image;
use MYT\MakeYourTeamBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;

class PublicController extends Controller
{

    public function indexAction($lastUsername = null, $error = null)
    {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $em->getRepository('MakeYourTeamBundle:Annonce');

//        $annonce = $annonceRepository->find(8);

//        $listCompetenceAnnonce = $em->getRepository("MakeYourTeamBundle:AnnonceCompetence")->findBy(array('annonce' => $annonce));

        $annonces = $annonceRepository->findAll();

        $lastIndex = @array_pop(array_keys($annonces));

        $user = $this->getUser();
        $this->get('session')->set('user', $user);
//        $this->get('security.context')->getToken()->isAuthenticated();
//        var_dump($this->get('security.context')->getToken()->getUser());die;


        $csrfToken = $this->has('form.csrf_provider')? $this->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;

        return $this->render("MakeYourTeamBundle:Public:index.html.twig", array(
            'annonces'          => $annonces,
            'user'              => $user,
            'csrf_token'        => $csrfToken,
            'last_username'     => $lastUsername,
            'error'             => $error,
            'lastIndex'         => $lastIndex,
        ));

    }


}
