<?php

namespace MYT\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use MYT\MakeYourTeamBundle\Form\MyUserCompetencesType;
use MYT\MakeYourTeamBundle\Form\MyUserCompetenceType;
use MYT\UserBundle\Form\Type\ProfileFormType;
use MYT\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
    /**
     * Show the user
     */
    public function showAction($username = null)
    {
        $user_connecte = $this->getUser();
        //On récupère l'utilisateur concerné //Username passé en GET
        if(isset($_GET['username'])){
            $username = $_GET['username'];
        }
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository('UserBundle:MyUser');
        $user_competence_repository = $em->getRepository('MakeYourTeamBundle:MyUserCompetence');
        $competence_repository = $em->getRepository('MakeYourTeamBundle:Competence');

        if(isset($username)){
            $user = $userRepository->getUserByUsername($username);
            $competences = $user_competence_repository->findByUser($user);
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
            return $this->render('FOSUserBundle:Profile:show.html.twig', array(
                'user'          => $user,
                'user_connecte' => $user_connecte,
                'competences'   => $competences,
            ));
        }

        $competences = $user_competence_repository->findByUser($user_connecte);
//        var_dump(\Doctrine\Common\Util\Debug::dump($competences));die;
//        foreach($competences as $uc){
//            $competence = $uc->getCompetence();
//            $competence = $competence_repository->find($competence->getId());
//        }

        return $this->render('FOSUserBundle:Profile:show_mine.html.twig', array(
            'user'        => $user_connecte,
            'competences' => $competences,
        ));
    }

    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
//        $form = $this->createForm(new ProfileFormType());
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Profile:edit_profile.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editMyUserCompetencesAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();

        $competences = array(
            'myuser_competences' => $user->getMyuserCompetences()
        );

        $form = $this->createForm(new MyUserCompetencesType(), $competences);
        $form->handleRequest($request);

        if(!$form->isValid()){
            $user_repository = $em->getRepository('MakeYourTeamBundle:MyUserCompetence');
            $user_repository->deleteByUser($user);
            $em->flush();
        }

        if($form->isValid()){
            foreach($form->getData()['myuser_competences'] as $comp){
                $comp->setUser($user);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        return $this->render('FOSUserBundle:Profile:edit_myusercompetences.html.twig', array(
            'form' => $form->createView()
        ));

    }


}
