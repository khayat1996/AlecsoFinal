<?php
/**
 * Created by PhpStorm.
 * User: Mars
 * Date: 10/04/2019
 * Time: 20:55
 */

namespace Alecso\EvenementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class EvenementUserController extends Controller
{
    /**
     * List Des Evenements
     *
     */
    public function viewAction()
    {
        $evenements = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        return $this->render('@AlecsoEvenement/User/viewEvent.html.twig',['events' => $evenements]);
    }

    public function showEventAction($id)
    {
        $evenements = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('AlecsoEvenementBundle:Evenement')->find($id);
        $eventnbr = $evenement->getIdUser()->count();
        if($evenement->getIdAdmin() == null){
            $partenaire = $evenement->getIdPartenaire()->first();
        }else{
            $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->findOneBy([ 'idUser' => null ]);
        }
        return $this->render('@AlecsoEvenement/User/show.html.twig',[
            'event' => $evenement,
            'eventnbr' => $eventnbr,
            'partenaire' => $partenaire,
            'events' => $evenements,
        ]);
    }


    /**
     * Delete Un Evenement .
     *
     */
    public function participeAction($id)
    {
        $evenements = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('AlecsoEvenementBundle:Evenement')->find($id);
        $usid = $this->get('security.token_storage')->getToken()->getUser();
        $eventnbr = $evenement->getIdUser()->count();
        $user = $em->getRepository('AlecsoEvenementBundle:User')->find($usid);
        if(($eventnbr < $evenement->getNbrPart()) && !($evenement->getIdUser()->contains($user))){
            $evenement->addIdUser($user);
            $user->addIdEvent($evenement);
            $em->flush($user);
            $em->flush($evenement);
            $mailer = $this->container->get('mailer');
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com',465,'ssl')
                ->setUsername('*****')
                ->setPassword('******');
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance('Test')
                ->setSubject('Alecso Message - Participation a Un Evenement [ '.$evenement->getTitle().' ]')
                ->setFrom('seif.rhouma19@gmail.com')
                ->setTo('x199103@gmail.com')
                ->setBody('Merçi pour votre Participation a notre Evenement');
            $this->get('mailer')->send($message);
        }
        return $this->redirectToRoute('alecso_evenement_homepage_user',['events' => $evenements]);
    }

    public function viewParticipeAction()
    {
        $evenements = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        $em = $this->getDoctrine()->getManager();
        $usid = $this->get('security.token_storage')->getToken()->getUser();
        $user = $em->getRepository('AlecsoEvenementBundle:User')->find($usid);
        return $this->render('@AlecsoEvenement/User/viewParticip.html.twig',[
            'user' => $user,
            'events' => $evenements
        ]);
    }

    public function annulePartAction($id)
    {
        $evenements = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        $event = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->find($id);
        $em = $this->getDoctrine()->getManager();
        $usid = $this->get('security.token_storage')->getToken()->getUser();
        $user = $em->getRepository('AlecsoEvenementBundle:User')->find($usid);
        $user->removeIdEvent($event);
        $event->removeIdUser($user);
        $em->flush($user);
        $em->flush($event);
        return $this->redirectToRoute('alecso_evenement_participe_view_user',[
            'user' => $user,
            'events' => $evenements
        ]);
    }
}