<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction()
    {
        return $this->render('user_home.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/home")
     */
    public function redirectAction()
    {
        $authCheker =$this ->container -> get ('security.authorization_checker');
        if( $authCheker -> isGranted('ROLE_SUPER_ADMIN')){
            return $this->render('@App/Security/admin_home.html.twig');

        }elseif ($authCheker -> isGranted('ROLE_USER')){
            return $this->render('@App/Security/user_home.html.twig');

        }else{
            return $this->render('@FOSUser/Security/login.html.twig');

        }}



}
