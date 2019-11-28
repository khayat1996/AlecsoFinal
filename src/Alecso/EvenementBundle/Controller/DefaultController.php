<?php

namespace Alecso\EvenementBundle\Controller;

use Alecso\EvenementBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\HttpFoundation\Request;
use Alecso\EvenementBundle\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@AlecsoEvenement/Admin/index.html.twig');
    }
    public function indexPartAction()
    {
        return $this->render('@AlecsoEvenement/Partenaire/index.html.twig');
    }
    public function indexUserAction()
    {
        return $this->render('@AlecsoEvenement/User/index.html.twig');
    }
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $partenaire = $em->getRepository('AlecsoEvenementBundle:Partenaire')->findOneBy([ 'idUser' => null ]);
        $actualnbr = 0;
        $eventnbr = $em->getRepository('AlecsoEvenementBundle:Evenement')->createQueryBuilder('e')->select('COUNT(e)')->where('e.idAdmin IS NOT NULL')->getQuery()->getSingleScalarResult();
        $comptnbr = 0;
        $offrenbr = 0;
        $user = $this->get('security.token_storage')->getToken()->getUser();
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
                return $this->redirectToRoute('alecso_admin_editprofil');
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
            return $this->redirectToRoute('alecso_admin_editprofil');
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
                return $this->redirectToRoute('alecso_admin_editprofil');
            }else{
                return $this->redirectToRoute('fos_user_security_logout');
            }
        }


        return $this->render('@AlecsoEvenement/Admin/profile.html.twig',['partenaire' => $partenaire ,
            'actualnbr' => $actualnbr,
            'eventnbr' => $eventnbr,
            'comptnbr' => $comptnbr,
            'offrenbr' => $offrenbr,
            'form' => $form->CreateView(),
            'formpart' => $formpart->CreateView(),
            'formpass'=> $formpass->CreateView()
            ]);
    }

    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getIdEvent()] = $entity->getTitle();
        }
        return $realEntities;
    }


    function testAction(Request $request)
    {

        /*
                $em = $this->getDoctrine()->getManager();
                $requestString = $request->get('q');
                $entities =  $em->getRepository('AlecsoEvenementBundle:Evenement')->findByEntitiesByString($requestString);
                if(!$entities) {
                    $result['entities']['error'] = "keine Einträge gefunden";
                } else {

                    $result['entities'] = $this->getRealEntities($entities);
                    echo 'hello else';
                }
                return new Response(json_encode($result));
                */
        $evenement = new Evenement();
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('AlecsoEvenementBundle:Evenement')->findAll();
        $form = $this->createFormBuilder($evenements)
            ->add('title',null ,array('label' => false , ) )->getForm();
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()&&($form->isValid())){
            echo 'enter';
            $evenement = $em->getRepository("AlecsoEvenementBundle:Evenement")
                ->findBy(array('title'=>$evenement->getTitle()));
            var_dump($evenement);
            return new JsonResponse($evenements);

        }
        return $this->render('@AlecsoEvenement/Admin/statistique.html.twig',[
            'evenements' => $evenements,
            'form' => $form->CreateView()

        ]);
                /*
                        $searchTerm = $request->query->get('search');

                        $em = $this->getDoctrine()->getManager();
                        $search = $em->getRepository('AlecsoEvenementBundle:Evenement')->searchClassifieds($searchTerm);

                        $results = $query->getResult();

                        $content = $this->renderView('search-result.html.twig', [
                            'results' => $results
                        ]);

                        $response = new JsonResponse();
                        $response->setData(array('classifiedList' => $content));
                        */
    }
    function testsearchAction(Request $request)
    {
        var_dump($request);
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->query->get('search');
        $entities =  $em->getRepository('AlecsoEvenementBundle:Evenement')->findByEntitiesByString($requestString);
        if(!$entities) {
            $result['entities']['error'] = "keine Einträge gefunden";
        } else {
            //var_dump($requestString);
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));
    }


}
