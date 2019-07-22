<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class ClientController
 * @package AppBundle\Controller
 * @Route(path="/client", methods={"GET"})
 */
class ClientController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction()
    {

        $client = new Client();
        $client->setNom('ELbenney');
        $client->setPrenom('Ferdaws');
        $client->setMail('ferdaws.elbenney@gmail.com');
        $client->setMdp('azerty');
        $client->setEtat('true');
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return $this->render('AppBundle:Client:add.html.twig', array('client' => $client
        ));
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
        dump($client);die;
//        return $this->render('AppBundle:Client:list.html.twig', array('client' => $client
//
//        ));
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
