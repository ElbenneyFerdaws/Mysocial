<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EntrepriseController
 * @package AppBundle\Controller
 * @Route(path="/entreprise", methods={"GET"})
 */
class EntrepriseController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction(Request $request)
    {
        $entreprise = new Entreprise();
        $entreprise->setNom('ELbenney');
        $entreprise->setPrenom('Ferdaws');
        $entreprise->setMail('ferdaws.elbenney@gmail.com');
        $entreprise->setEtat('true');
        $em = $this->getDoctrine()->getManager();
        $em->persist($entreprise);
        $em->flush();


        // Reste de la méthode qu'on avait déjà écrit
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'entreprise bien enregistrée.');

             return $this->redirectToRoute('app_entreprise_add_view', array('id' => $entreprise->getId()));
        }

        // Si on n'est pas en POST, alors on affiche le ...
        return $this->render('@App/Entreprise/add.html.twig', array('entreprise' => $entreprise));



    }

    /**
     * @Route("/update/{entrepriseId}")
     */
    public function updateAction($entrepriseId)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entreprise = $entityManager->getRepository(Entreprise::class)->find($entrepriseId);

        if (!$entreprise) {
            throw $this->createNotFoundException(
                'No entreprise found for id '.$entrepriseId
            );
        }

        $entreprise->setNom('New entreprise name!');
        $entityManager->flush();

        return $this->redirectToRoute('homepage');



    }

    /**
     * @Route("/list")
     */
    public function listAction()
    {

        $em = $this->getDoctrine()->getManager();
        $entreprise = $em->getRepository('AppBundle:Entreprise')
            ->findAll();
//dump($entreprise);die;

        return $this->render('@App/Entreprise/list.html.twig', array(
           'entreprise' => $entreprise
        ));
    }

    /**
     * @Route("/enable/{entreprise}")
     */
    public function enableAction(Request $request, Entreprise $entreprise=null)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entrepriseEtat = $entreprise -> getEtat();
        $entreprise->setEtat(!$entrepriseEtat);
        $entityManager->flush();

        return $this->render('AppBundle:Entreprise:enable.html.twig', array(
            'entreprise' => $entreprise
        ));
    }

}
