<?php

namespace Alecso\EvenementBundle\Controller;

use Alecso\EvenementBundle\Entity\Evenement;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class EvenementPartController extends Controller
{
    /**
     * List Des Evenements
     *
     */
    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->findOneBy([ 'idUser' => $user ]);
        $result2 = $em->getRepository('AlecsoEvenementBundle:Evenement')
            ->createQueryBuilder('e')
            ->leftJoin('e.idPartenaire', 'p')
            ->where('p.idPartenaire = :id')
            ->setParameter('id', $partenaire->getIdPartenaire())
            ->getQuery()
            ->getResult();
        return $this->render('@AlecsoEvenement/Partenaire/viewEvent.html.twig',['events' => $result2]);
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
            $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->findOneBy([ 'idUser' => $user ]);

            $evenenment->addIdPartenaire($partenaire);
            $partenaire->addIdEvent($evenenment);

            $em->persist($evenenment);
            $em->flush($evenenment);
            $em->flush($partenaire);
            return $this->redirectToRoute('alecso_evenement_view_partenaire');
        }
        return $this->render('@AlecsoEvenement/Partenaire/ajouteEvent.html.twig', array(
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
        $em->remove($evenement);
        $em->flush();
        $this->addFlash('message','Hahahahha');
        return $this->redirectToRoute('alecso_evenement_view_partenaire');
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
            return $this->redirectToRoute('alecso_evenement_view_partenaire');
        }

        return $this->render('@AlecsoEvenement/Partenaire/editEvent.html.twig',[
            'form' => $form->CreateView()
        ]);
    }
    public function editProfileAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->findOneBy([ 'idUser' => $user->getId() ]);
        $actualnbr = 0;
        $eventnbr = $partenaire->getIdEvent()->count();
        $comptnbr = 0;
        $offrenbr = 0;

        $img = $user->getMedia();
        $imgpart = $partenaire->getMedia();
        $form = $this->createFormBuilder($user)
            ->add('nom',null ,array('label' => false) )
            ->add('prenom', null,array('label' => false))
            ->add('adresse', null,array('label' => false))
            ->add('codepost',null, array('label' => false))
            ->add('bio',TextareaType::class, array('label' => false))
            ->add('gender', ChoiceType::class, array('label' => false,
                'choices' => array('Femme' => 'Female', 'Homme' => 'Male'),
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('dob', BirthdayType::class, ['label' => false,
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
            ])
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
                ],'label' => false,
            ])
            ->add('email', EmailType::class, array('label' => false,'translation_domain' => 'FOSUserBundle'))

            ->add('username', null, array('label' => false,'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword',PasswordType::class ,array('label' => false) )
            ->add('media', FileType::class , array('label' => 'Nombre Maximum de Participants : ','attr' =>
                array(
                    'accept' => ".jpg,.jpeg,.png"
                ), 'required' => false,'data_class' => null,'label' => false))
            ->getForm();

        $formpart = $this->get('form.factory')
            ->createNamedBuilder('formpart', FormType::class, $partenaire)
            ->add('nom',null ,array('label' => false) )
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Type 1' => 1,
                    'Type 2' => 2,
                    'Type 3' => 3,
                ],'label' => false
            ])
            ->add('description', TextareaType::class,array('label' => false))
            ->add('adresse', null,array('label' => false))
            ->add('codepost',null, array('label' => false))
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
                ],'label' => false,
            ])
            ->add('tel1',null ,array('label' => false))
            ->add('tel2', null,array('label' => false))
            ->add('media', FileType::class , array('label' => 'Nombre Maximum de Participants : ','attr' =>
                array(
                    'accept' => ".jpg,.jpeg,.png" , 'name' => 'partfile'
                ), 'required' => false,'data_class' => null,'label' => false))
            ->getForm();

        $formpass = $this->get('form.factory')
            ->createNamedBuilder('formpass', FormType::class, $user)
            ->add('current_password', PasswordType::class, array(
                'label' => 'form.current_password',
                'translation_domain' => 'FOSUserBundle',
                'mapped' => false,'label' => false,
                'attr' => array(
                    'autocomplete' => 'current-password',
                ),
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => false),
                'second_options' => array('label' => false),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->getForm();
        /*
                $encoder_service = $this->get('security.encoder_factory');
                $encoder = $encoder_service->getEncoder($user);
                $bool = $encoder->isPasswordValid($user->getPassword(),'09031991',$user->getSalt());
                $encoded = $encoder->encodePassword($user, '09031991');
                echo 'this is Coded Pass : ->  '.$user->getPassword();
                echo '<br>';
                echo 'this is Coded Pass : ->  '.$encoded;
                echo '<br>';
                echo 'Other Pass : ->  '.$bool;
                die();
        */
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $form["plainPassword"]->getData();
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $bool = $encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt());
            if($bool == 1){
                $user = $this->get('security.token_storage')->getToken()->getUser();
                $file = $request->files->get('form')['media'];
                if($form->get('media')->getData() == null){
                    $user->setMedia($img);
                }else{
                    $uploads_folder = $this->getParameter('uploads_directory');
                    $filename =md5(uniqid()). '.' . $file->guessExtension();
                    $file->move(
                        $uploads_folder,
                        $filename
                    );
                    $user->setMedia($filename);
                }
                $em = $this->getDoctrine()->getManager();
                $user = $em->getRepository('AlecsoEvenementBundle:User')->find($user->getId());
                $em->flush($user);
                return $this->redirectToRoute('alecso_partenaire_editprofil');
            }else{
                return $this->redirectToRoute('fos_user_security_logout');
            }
        }

        $formpart->handleRequest($request);
        if($formpart->isSubmitted() && $formpart->isValid()){
            $file2 = $request->files->get('formpart')['media'];
            if($formpart->get('media')->getData() == null){
                $partenaire->setMedia($imgpart);
            }else{
                $uploads_folder = $this->getParameter('uploads_directory');
                $filename2 = md5(uniqid()). '.' . $file2->guessExtension();
                $file2->move(
                    $uploads_folder,
                    $filename2
                );
                $partenaire->setNom($formpart->get('nom')->getData());
                $partenaire->setMedia($filename2);
            }
            $em = $this->getDoctrine()->getManager();
            $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->find($partenaire->getIdPartenaire());
            //$em->persist($partenaire);
            $em->flush($partenaire);
            return $this->redirectToRoute('alecso_partenaire_editprofil');
        }

        $formpass->handleRequest($request);
        if($formpass->isSubmitted() && $formpass->isValid()){
            $password2 = $formpass["current_password"]->getData();
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $bool = $encoder->isPasswordValid($user->getPassword(),$password2,$user->getSalt());
            if($bool == 1){
                $password3 = $formpass["plainPassword"]->getData();
                $encoded = $encoder->encodePassword($user, $password3);
                $user = $this->get('security.token_storage')->getToken()->getUser();
                $user->setPassword($encoded);
                $em->flush($user);
                return $this->redirectToRoute('alecso_partenaire_editprofil');
            }else{
                return $this->redirectToRoute('fos_user_security_logout');
            }
        }


        return $this->render('@AlecsoEvenement/Partenaire/profile.html.twig',['partenaire' => $partenaire ,
            'actualnbr' => $actualnbr,
            'eventnbr' => $eventnbr,
            'comptnbr' => $comptnbr,
            'offrenbr' => $offrenbr,
            'form' => $form->CreateView(),
            'formpart' => $formpart->CreateView(),
            'formpass'=> $formpass->CreateView()
        ]);
    }

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
        return $this->render('@AlecsoEvenement/Partenaire/show.html.twig',[
            'event' => $evenement,
            'eventnbr' => $eventnbr,
            'partenaire' => $partenaire
        ]);
    }
}
