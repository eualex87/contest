<?php
/**
 * Created by PhpStorm.
 * User: Ioana
 * Date: 4/19/2015
 * Time: 6:34 PM
 */

namespace AdminBundle\Controller;

use Doctrine\ORM\EntityManager;
use SiteBundle\Entity\Detalii;
use SiteBundle\Repository\DetaliiRepository;
use SiteBundle\Repository\ImaginiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin", name="admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');

        $inscrieri = $detaliiRepository->getNewRegisters();

        $numarInscrieri = count($detaliiRepository->findBy(array('aprobaMesaj'=>'-1','aprobaImagine'=>'-1')));

        return $this->render('AdminBundle:Pages:home.html.twig', array(
            'title' => 'Aproba inscrieri',
            'inscrieriNr' => $numarInscrieri,
            'inscrieri' => $inscrieri
        ));
    }

    /**
     * @Route("/extrageri", name="extrageri")
     */
    public function extrageriAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');

        $premiiZilnice = $detaliiRepository->findBy(array('premiu'=>Detalii::PRIZE_HOUR));
        $premiiZilnice = array('acordate'=>count($premiiZilnice), 'ramase'=> (Detalii::PREMII_TOTALE_ZILNICE-count($premiiZilnice)));
        $premiiSaptamanale = $detaliiRepository->findBy(array('premiu'=>Detalii::PRIZE_WEEK));
        $premiiSaptamanale = array('acordate'=>count($premiiSaptamanale), 'ramase'=> (Detalii::PREMII_TOTALE_SAPTAMANALE-count($premiiSaptamanale)));
        $premiuFinal = $detaliiRepository->findBy(array('premiu'=>Detalii::PRIZE_FINAL));
        $premiuFinal = array('acordate'=>count($premiuFinal), 'ramase'=> (Detalii::PREMIU_FINAL-count($premiuFinal)));


        return $this->render('AdminBundle:Pages:extrageri.html.twig', array(
            'title' => 'Extrageri',
            'premiiZilnice' => $premiiZilnice,
            'premiiSaptamanale' => $premiiSaptamanale,
            'premiuFinal' => $premiuFinal
        ));
    }

    /**
     * @Route("/rapoarte", name="rapoarte")
     */
    public function rapoarteAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');

        $femei = $detaliiRepository->findBy(array('gen'=>Detalii::GEN_FEMININ));
        $barbati = $detaliiRepository->findBy(array('gen'=>Detalii::GEN_MASCULIN));

        $femei = count($femei);
        $barbati = count($barbati);

        $inscrieriZi = array('femei' => $femei, 'barbati' => $barbati);
        $inscrieri = $detaliiRepository->getRegistersByDay();

        return $this->render('AdminBundle:Pages:rapoarte.html.twig', array(
            'title' => 'Rapoarte',
            'inscrieriZi' => $inscrieriZi,
            'inscrieri' => $inscrieri
        ));
    }

    /**
     * @Route("/aproba/{id}", name="aproba")
     */
    public function aprobaAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');

        /** @var Detalii $inscriere */
        $inscriere = $detaliiRepository->findOneBy(array('id'=> $id));

        if (!$inscriere) {
            throw $this->createNotFoundException(
                'Nu exista inscriere cu id-ul '.$id
            );
        }

        $inscriere->setAprobaMesaj(1);
        $inscriere->setAprobaImagine(1);
        $inscriere->setPremiu(0);

        $em->flush();

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/refuza/{id}", name="refuza")
     */
    public function refuzaAction($id)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var \SiteBundle\Repository\DetaliiRepository $detaliiRepository */
        $detaliiRepository = $em->getRepository('SiteBundle:Detalii');

        /** @var Detalii $inscriere */
        $inscriere = $detaliiRepository->findOneBy(array('id'=> $id));

        if (!$inscriere) {
            throw $this->createNotFoundException(
                'Nu exista inscriere cu id-ul '.$id
            );
        }

        $inscriere->setAprobaMesaj(0);
        $inscriere->setAprobaImagine(0);

        $em->flush();

        return $this->redirectToRoute('admin');
    }
}