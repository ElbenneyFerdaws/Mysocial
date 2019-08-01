<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ClientController
 * @package AppBundle\Controller
 * @Route(path="/client")
 */
class ClientController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction(Request $request)
    {

       $client = new Client();
       $form=$this->createForm(ClientType::class,$client);
       $form->handleRequest($request);

       if($form->isSubmitted()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
       }
        return $this->render('AppBundle:Client:add.html.twig', array('form' => $form->createview()));
    }

    /**
     * @Route("/update/{clientId}")
     */
    public function updateAction($clientId)
    {$entityManager = $this->getDoctrine()->getManager();
        $client = $entityManager->getRepository(Client::class)->find($clientId);

        if (!$client) {
            throw $this->createNotFoundException(
                'No client found for id '.$clientId
            );
        }

        $client->setNom('New client name!');
        $entityManager->flush();




        return $this->render('AppBundle:Client:update.html.twig', array(
            'client' => $client
        ));
    }

    /**
     * @Route("/list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')
            ->findAll();
//        dump($client);die;
        return $this->render('AppBundle:Client:list.html.twig', array('client' => $client

        ));
    }

    /**
     * @Route("/enable/{client}")
     */
    public function enableAction(Request $request, Client $client=null)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $clientEtat = $client -> getEtat();
        $client->setEtat(!$clientEtat);
        $entityManager->flush();
        return $this->render('AppBundle:Client:enable.html.twig', array(
            // ...
        ));
    }

}
