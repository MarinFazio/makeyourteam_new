<?php

namespace MYT\MakeYourTeamBundle\Controller;

use MYT\MakeYourTeamBundle\Entity\Annonce;
use MYT\MakeYourTeamBundle\Entity\Image;
use MYT\MakeYourTeamBundle\Entity\MyUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;

class PublicController extends Controller
{

    public function indexAction($page=1, $lastUsername = null, $error = null)
    {
        $em = $this->getDoctrine()->getManager();
        $annonceRepository = $em->getRepository('MakeYourTeamBundle:Annonce');


        $maxAnnonces = 1;
        $nb_annonces = $annonceRepository->countPublishedTotal();
        $pagination = array(
            'page'          => $page,
            'route'         => 'annonce_page',
            'nb_pages'      => ceil($nb_annonces[1] / $maxAnnonces),
            'route_params'  => array()
        );

        $annonces = $this->getDoctrine()->getRepository('MakeYourTeamBundle:Annonce')
            ->getList($page, $maxAnnonces);

//        var_dump($pagination);die;

//        $annonces = $annonceRepository->getPublishedAnnonces();
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
            'pagination'        => $pagination,
        ));

    }


}
