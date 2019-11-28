<?php

namespace Alecso\EvenementBundle\Controller;

use Alecso\EvenementBundle\Entity\Evenement;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class EvenementController extends Controller
{
    /**
     * List Des Evenements
     *
     */
    public function viewAction()
    {
        $evenements = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        return $this->render('@AlecsoEvenement/Admin/viewEvent.html.twig',['events' => $evenements]);
    }

    /**
     * Ajoute Un Evenement .
     *
     */
    public function ajouteAction(Request $request)
    {
        $evenenment = new Evenement();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createFormBuilder($evenenment)
            ->add('title', TextType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 250
                ),'required' => true))
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Type 1' => 1,
                    'Type 2' => 2,
                    'Type 3' => 3,
                ],'label' => false,
            ])
            ->add('description', TextareaType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('date_start', DateTimeType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('date_fin', DateTimeType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('ville', ChoiceType::class, [
                'choices'  => [
                    'Algérie' => 'Algérie',
                    'Bahreïn' => 'Bahreïn',
                    'Comores' => 'Comores',

                    'Djibouti' => 'Djibouti',
                    'Égypte' => 'Égypte',
                    'Iraq' => 'Iraq',

                    'Jordanie' => 'Jordanie',
                    'Koweït' => 'Koweït',
                    'Liban' => 'Liban',

                    'Libye' => 'Libye',
                    'Mauritanie' => 'Mauritanie',
                    'Maroc' => 'Maroc',

                    'Oman' => 'Oman',
                    'Palestine' => 'Palestine',
                    'Qatar' => 'Qatar',

                    'Arabie saoudite' => 'Arabie saoudite',
                    'Somalie' => 'Somalie',
                    'Soudan' => 'Soudan',

                    'Syrie' => 'Syrie',
                    'Tunisie' => 'Tunisie',
                    'Émirats arabes unis' => 'Émirats arabes unis',

                    'Yémen' => 'Yémen',
                ],'label' => false, 'attr' =>
                    array(
                        'class' => 'form-control'
                    )
            ])
            ->add('adresse', TextType::class , array('label' => false,'attr' =>
                array(
                    //'maxlength' => 5
                ),'required' => true))
            ->add('code_post', TextType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('nbr_part', IntegerType::class , array('label' => false,'attr' =>
                array(
                    'min' =>0, 'max' =>100
                ),'required' => true))
            ->add('media', FileType::class , array('label' => false,'attr' =>
                array(
                    'accept' => ".jpg,.jpeg,.png"
                )))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $request->files->get('form')['media'];
            $uploads_folder = $this->getParameter('uploads_directory');
            $filename =md5(uniqid()). '.' . $file->guessExtension();
            $file->move(
                $uploads_folder,
                $filename
            );
            $evenenment->setMedia($filename);
            $em = $this->getDoctrine()->getManager();

            $admin = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Admin')->find($user);
            $evenenment->setIdAdmin($admin);
            $em->persist($evenenment);
            $em->flush($evenenment);
            return $this->redirectToRoute('alecso_evenement_view');
        }
        return $this->render('@AlecsoEvenement/Admin/ajouteEvent.html.twig', array(
            'form' => $form->CreateView(),
            'evenement' => $evenenment
        ));
    }

    /**
     * Delete Un Evenement .
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('AlecsoEvenementBundle:Evenement')->find($id);
        $evenement->setIdAdmin(null);
        $em->remove($evenement);
        $em->flush();
        $this->addFlash('message','Hahahahha');
        return $this->redirectToRoute('alecso_evenement_view');
    }

    /**
     * Update Un Evenement .
     *
     */
    public function updateAction($id,Request $request)
    {
        $evenement = $this->getDoctrine()->getRepository('AlecsoEvenementBundle:Evenement')->find($id);
        $img = $evenement->getMedia();
        $evenement->setTitle($evenement->getTitle());
        $evenement->setType($evenement->getType());
        $evenement->setDescription($evenement->getDescription());

        $evenement->setDateStart($evenement->getDateStart());
        $evenement->setDateFin($evenement->getDateFin());

        $evenement->setVille($evenement->getVille());
        $evenement->setAdresse($evenement->getAdresse());
        $evenement->setCodePost($evenement->getCodePost());

        $evenement->setNbrPart($evenement->getNbrPart());


        $form = $this->createFormBuilder($evenement)
            ->add('title', TextType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 250
                ),'required' => true))
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Type 1' => 1,
                    'Type 2' => 2,
                    'Type 3' => 3,
                ],'label' => false,
            ])
            ->add('description', TextareaType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('date_start', DateTimeType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('date_fin', DateTimeType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('ville', ChoiceType::class, [
                'choices'  => [
                    'Algérie' => 'Algérie',
                    'Bahreïn' => 'Bahreïn',
                    'Comores' => 'Comores',

                    'Djibouti' => 'Djibouti',
                    'Égypte' => 'Égypte',
                    'Iraq' => 'Iraq',

                    'Jordanie' => 'Jordanie',
                    'Koweït' => 'Koweït',
                    'Liban' => 'Liban',

                    'Libye' => 'Libye',
                    'Mauritanie' => 'Mauritanie',
                    'Maroc' => 'Maroc',

                    'Oman' => 'Oman',
                    'Palestine' => 'Palestine',
                    'Qatar' => 'Qatar',

                    'Arabie saoudite' => 'Arabie saoudite',
                    'Somalie' => 'Somalie',
                    'Soudan' => 'Soudan',

                    'Syrie' => 'Syrie',
                    'Tunisie' => 'Tunisie',
                    'Émirats arabes unis' => 'Émirats arabes unis',

                    'Yémen' => 'Yémen',
                ],'label' => false
            ])
            ->add('adresse', TextType::class , array('label' => false,'attr' =>
                array(
                    //'maxlength' => 5
                ),'required' => true))
            ->add('code_post', TextType::class , array('label' => false,'attr' =>
                array(
                    'maxlength' => 5
                ),'required' => true))
            ->add('nbr_part', IntegerType::class , array('label' => false,'attr' =>
                array(
                    'min' =>0, 'max' =>100
                ),'required' => true))
            ->add('media', FileType::class , array('label' => false,'attr' =>
                array(
                    'accept' => ".jpg,.jpeg,.png"
                ), 'required' => false,'data_class' => null))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $request->files->get('form')['media'];
            if($form->get('media')->getData() == null){
                $evenement->setMedia($img);
            }else{
                $uploads_folder = $this->getParameter('uploads_directory');
                $filename =md5(uniqid()). '.' . $file->guessExtension();
                $file->move(
                    $uploads_folder,
                    $filename
                );
                $evenement->setMedia($filename);
            }
            $em = $this->getDoctrine()->getManager();
            $evenement = $em->getRepository('AlecsoEvenementBundle:Evenement')->find($id);

            $em->flush();
            return $this->redirectToRoute('alecso_evenement_view');
        }

        return $this->render('@AlecsoEvenement/Admin/editEvent.html.twig',[
            'form' => $form->CreateView()
        ]);
    }

    /**
     * Delete Un Evenement .
     *
     */
    public function statistiqueAction()
    {
        return $this->render('@AlecsoEvenement/Admin/statistique.html.twig');
    }
    /**
     * Show Un Evenement .
     *
     */
    public function showEventAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('AlecsoEvenementBundle:Evenement')->find($id);
        $eventnbr = $evenement->getIdUser()->count();
        if($evenement->getIdAdmin() == null){
            $partenaire = $evenement->getIdPartenaire()->first();
        }else{
            $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->findOneBy([ 'idUser' => null ]);
        }
        return $this->render('@AlecsoEvenement/Admin/show.html.twig',[
            'event' => $evenement,
            'eventnbr' => $eventnbr,
            'partenaire' => $partenaire
        ]);
    }


}
