<?php

namespace ChamaicaineBundle\Controller;

use ChamaicaineBundle\Entity\Date;
use ChamaicaineBundle\Entity\DescEn;
use ChamaicaineBundle\Entity\DescFr;
use ChamaicaineBundle\Entity\Image;
use ChamaicaineBundle\Entity\Contact;
use ChamaicaineBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    public function homeAction() {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository(Image::class)->findAll();
        $descFr = $em->getRepository(DescFr::class)->findOneById(1);
        $descEn = $em->getRepository(DescEn::class)->findOneById(1);
        $dates = $em->getRepository(Date::class)->dateByDesc();
        $contact = new Contact();

        
        $formContact = $this->createForm(ContactType::class, $contact);


        return $this->render('@Chamaicaine/client/base_client.html.twig', array(
            'images' => $images,
            'descFr' => $descFr,
            'descEn' => $descEn,
            'dates' => $dates,
            'formContact' => $formContact->createView(),
        ));
    }

    public function getMapAction(Request $req) {
        $em = $this->getDoctrine()->getManager();
        $geocoder = new GeocoderService(
            new Client(),
            new GuzzleMessageFactory()
        );
        $id = $req->request->get('id');
        $date = $em->getRepository(Date::class)->findOneById($id);

        $address = $date->getAddress().' ,'.$date->getZip().' '.$date->getTown();
        $request = new GeocoderAddressRequest($address);
        $response = $geocoder->geocode($request);
        $loc = $response->getResults()[0]->getGeometry()->getLocation();
        $lat = $loc->getLatitude();
        $long = $loc->getLongitude();
        $coord = new Coordinate($lat, $long);

        $map = new Map();
        $map->setCenter($coord);
        $map->getOverlayManager()->addMarker(new Marker($coord));
        $map->setMapOption('zoom', 14);

        $content = $this->renderView('@Chamaicaine/client/map.html.twig', array(
            'map' => $map
        ));

        return new JsonResponse($content);
    }
    
    public function sendContactAction(Request $request) {
        
    }
}