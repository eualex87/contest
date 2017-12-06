<?php
/**
 * Created by PhpStorm.
 * User: Ioana
 * Date: 4/19/2015
 * Time: 6:34 PM
 */

namespace SiteBundle\Controller;

use Doctrine\ORM\EntityManager;
use SiteBundle\Bundle\Repository\ImaginiRepository;
use SiteBundle\Entity\Detalii;
use SiteBundle\Entity\Imagini;
use SiteBundle\Form\SiteType;
use SiteBundle\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use SiteBundle\Bundle\Repository\DetaliiRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\MimeType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Util\ClassUtils;

class SiteController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        /** @var SiteType $share */
        $share = $this->get('site.form');
        $form = $this->createForm($share);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');
        /** @var \SiteBundle\Repository\ImaginiRepository $imaginiRepository */
        $imaginiRepository = $em->getRepository('SiteBundle:Imagini');

        $castigatori =$detaliiRepository->getCastigatori() ;

        $messages = $detaliiRepository->findBy(array('aprobaMesaj' => 1));
        $images = $imaginiRepository->getAprovedImages();

        return $this->render('SiteBundle::layout.html.twig',
            array(
                'form' => $form->createView(),
                'messages' => $messages,
                'images' => $images,
                'castigatori' => $castigatori
            ));
    }

    public function sendAction(Request $request)
    {
        $folderUpload = 'uploads';
        $dir = $this->get('kernel')->getRootDir() . '/../web/'.$folderUpload;

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');
        /** @var ImaginiRepository $imaginiRepository */
        $imaginiRepository = $em->getRepository('SiteBundle:Imagini');
        /** @var RegisterService $registerService */
        $registerService = $this->container->get('site.register');

        $results = $request->request->all();
        $results = $results['share'];
        $file = $request->files->get('share');
        $file = $file['image'];

        if ($file == null && $results['message'] == null) {
            return new JsonResponse(array('error'=>'Trebuie sa te inscrii cu un mesaj amuzant sau o fotografie funny!'));
        }

        if ($file != null) {

            $name = $file->getClientOriginalName();
            $mimeType = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
            $type = $file->getClientMimeType();
            $extension = explode('/', $type);
            $hash = md5($name).'_'.time().'.'.$extension[1];
            if (!in_array($type,$mimeType)) {
                return new JsonResponse(array('error'=>'Fisierul trebuie sa fie de tipul jpeg, jpg, png sau gif'));
            }
            $size = $file->getSize();
            if ($size > 1000000) {
                return new JsonResponse(array('error'=>'Fisierul nu trebuie sa depaseasca 1 MB. Poti si funny si cu o poza mai mica!'));
            }

        }

        //validari
        $messageRequired = '';
        $messages = array();
        $response['error'] = false;

        //validation Email
        $results['required_email'] = trim($results['required_email']);
        if ($results['required_email'] == '') {
            $response['error'] = true;
            $messageRequired = $messageRequired.' Email,';
        } elseif (!filter_var($results['required_email'], FILTER_VALIDATE_EMAIL)) {
            $response['error'] = true;
            $messages = 'Adresa de email nu este valida.';
        } else {
            $register = $detaliiRepository->findOneBy(array('email' => $results['required_email']));
            if (!is_null($register)) {
                return new JsonResponse(array('repeat'=>'Hmmm..tu te-ai mai inregistrat! Nu te mai stradui, deja esti funny!'));
            }
        }

        //validation Last Name
        if(trim($results['required_last_name']) == '') {
            $response['error'] = true;
            $messageRequired = $messageRequired.' Nume,';
        }
        $results['required_last_name'] = addslashes($results['required_last_name']);

        //validation First Name
        if(trim($results['required_first_name']) == '') {
            $response['error'] = true;
            $messageRequired = $messageRequired.' Prenume,';
        }
        $results['required_first_name'] = addslashes($results['required_first_name']);

        //validation Gender
        $results['required_sex'] = trim($results['required_sex']);
        if ($results['required_sex'] == '') {
            $response['error'] = true;
            $messageRequired = $messageRequired.' Gen,';
        }

        //validation Date
        if ($results['date'] == '')
        {
            $response['error'] = true;
            $messageRequired = $messageRequired.' Data,';
        } else {
            if (!checkdate($results['date']['month'], $results['date']['day'], $results['date']['year'])) {
                $response['error'] = true;
                $messages = $messages.' Data nasterii nu este valida.';
            } else {
                $results['date'] = $results['date']['year'].'-'.$results['date']['month'].'-'.$results['date']['day'];
            }
        }

        //validation Message
        if (trim($results['message']) != '' && strlen($results['message']) > 300) {
            $response['error'] = true;
            $messages = $messages.' Mesajul nu trebuie sa fie mai mare de 300 de caractere.';
        }

        if ($response['error']) {
            $response['messageResult'] = $messageRequired!=''?'Urmatoarele campuri sunt obligatorii: '.$messageRequired.'\n'.$messages:$messages;
            return new JsonResponse($response);
        }
        /** if (image) first insert image */

        $id = null;
        if ($file != null) {
            try {
                $file->move($dir, $hash);
                $id = $registerService->saveImage($name, $folderUpload, $hash);
            } catch (\Exception $e) {
                return new JsonResponse(array('error'=>true,'messageResult'=>"Ceva a mers prost! Nu-mi dau seama ce, \n dar as aprecia daca ai mai incerca o data ;)"));
            }
        }

        try {
            $registerService->saveRegister($results, $id);
            $em->flush();

            if (date('Y')-date('Y',strtotime($results['date'])) > 50)
            {
                return new JsonResponse(array('confirm'=>"Esti chiar tare! Eu nu m-as fi gandit ca dupa 50 de ani as putea sa mai fiu 'funny'. Asteapta aici si o sa vezi si raspunsul, in curand!"));
            }
            return new JsonResponse(array('confirm'=>"O sa afli in scurt timp daca esti 'funny'. Daca iti vezi poza sau mesajul mai sus, este clar, m-ai dat pe spate!"));
        } catch (\Exception $e) {
            return new JsonResponse(array('error'=>true, 'messageResult'=>"Ceva a mers prost! Nu-mi dau seama ce, \n dar as aprecia daca ai mai incerca o data ;)"));
        }
    }
}