<?php

namespace ChamaicaineBundle\Controller;

use ChamaicaineBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository(Image::class)->findAll();

        return $this->render('@Chamaicaine/client/base_client.html.twig', array(
            'images' => $images
        ));
    }
}