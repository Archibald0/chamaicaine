<?php

namespace ChamaicaineBundle\Controller;

use ChamaicaineBundle\Entity\Date;
use ChamaicaineBundle\Entity\DescEn;
use ChamaicaineBundle\Entity\DescFr;
use ChamaicaineBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository(Image::class)->findAll();
        $descFr = $em->getRepository(DescFr::class)->findOneById(1);
        $descEn = $em->getRepository(DescEn::class)->findOneById(1);
        $dates = $em->getRepository(Date::class)->dateByDesc();

        return $this->render('@Chamaicaine/client/base_client.html.twig', array(
            'images' => $images,
            'descFr' => $descFr,
            'descEn' => $descEn,
            'dates' => $dates
        ));
    }
}