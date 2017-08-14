<?php

namespace ChamaicaineBundle\Controller;

use ChamaicaineBundle\Entity\Date;
use ChamaicaineBundle\Entity\Image;
use ChamaicaineBundle\Form\DateType;
use ChamaicaineBundle\Form\DescEnType;
use ChamaicaineBundle\Form\DescFrType;
use ChamaicaineBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $date = new Date();
        $image = new Image();
        $descFr = $em->getRepository('ChamaicaineBundle:DescFr')->findOneById(1);
        $descEn = $em->getRepository('ChamaicaineBundle:DescEn')->findOneById(1);

        $formDate = $this->createForm(DateType::class, $date);
        $formDescFr = $this->createForm(DescFrType::class, $descFr);
        $formDescEn = $this->createForm(DescEnType::class, $descEn);
        $formImage = $this->createForm(ImageType::class, $image);

        $dates = $em->getRepository('ChamaicaineBundle:Date')->dateByDesc();
        $images = $em->getRepository('ChamaicaineBundle:Image')->findAll();

        return $this->render('@Chamaicaine/admin/home.html.twig', array(
            'formDate' => $formDate->createView(),
            'formDescFr' => $formDescFr->createView(),
            'formDescEn' => $formDescEn->createView(),
            'formImage' => $formImage->createView(),
            'dates' => $dates,
            'images' => $images
        ));
    }

    public function addImageAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);

        $formImage->handleRequest($request);

        if ($request->isXmlHttpRequest()) {

            $file = $request->files->get('chamaicainebundle_image')['src'];

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_dir'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $image->setSrc($fileName);

            $em->persist($image);
            $em->flush();

            $content = $this->renderView('@Chamaicaine/admin/templates/img.html.twig', array(
                'image'=>$image
            ));

            return new JsonResponse($content);
        }
    }
    
    public function deleteImageAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('id');
        $image = $em->getRepository(Image::class)->findOneById($id);
        $path = $this->getParameter('images_dir') . '/' . $image->getSrc();

        $em->remove($image);
        unlink($path);
        $em->flush();

        $response = "#" . $id;

        return new Response($response);
    }

    public function addDescFrAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $desc = $em->getRepository('ChamaicaineBundle:DescFr')->findOneById(1);
        $form = $this->createForm('ChamaicaineBundle\Form\DescFrType', $desc);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()) {
            $em->flush();
            return new Response('Description Fr modifiée!');
        }
        return new Response('erreur');
    }

    public function addDescEnAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $desc = $em->getRepository('ChamaicaineBundle:DescEn')->findOneById(1);
        $form = $this->createForm('ChamaicaineBundle\Form\DescEnType', $desc);
        $form->handleRequest($request);

        if($request->isXmlHttpRequest()) {
            $em->flush();
            return new Response('Description En modifiée!');
        }
        return new Response('erreur');
    }

    public function addDateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $date = new Date();
        $form = $this->createForm(DateType::class, $date);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest()) {
            $dateDate = $request->request->get('date');
            $dataDate = preg_split( '/(\s|,)/', $dateDate );
            $dateTime = $request->request->get('time');
            $dateTime = explode(':', $dateTime);
            $datePicker = new \DateTime();
            $month = array(
                'January' => 1, 'February' => 2, 'March' => 3, 'April'=> 4, 'May' => 5,
                'June' => 6, 'July' => 7, 'August' => 8, 'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12
            );
            $datePicker->setDate($dataDate[3], $month[$dataDate[1]], $dataDate[0]);
            $datePicker->setTime($dateTime[0], $dateTime[1]);
            $date->setDate($datePicker);
            $em->persist($date);
            $em->flush();

            $content = $this->renderView('@Chamaicaine/admin/templates/date.html.twig', array(
                'date' => $date,
            ));

            return new JsonResponse($content);
        }

        return new Response('error');
    }

    public function deleteDateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('id');
        $date = $em->getRepository(Date::class)->findOneById($id);

        $em->remove($date);
        $em->flush();

        return new Response('Deleted');
    }
}