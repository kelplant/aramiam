<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CoreBundle\Form\UtilisateurType;

class UtilisateurController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $all_utilisateurs = $this->get('core.utilisateur_manager')->getRepository()->findAll();
        return $this->render('CoreBundle:Utilisateur:view.html.twig', array(
            'all' => $all_utilisateurs,
        ));
    }
}
