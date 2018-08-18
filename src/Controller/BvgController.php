<?php

namespace App\Controller;

use App\Entity\Incident;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BvgController extends AbstractController
{
    /**
     * @Route("/bvg", name="bvg")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BvgController.php',
        ]);
    }

    /**
     * @Route("/bvg/data_insert", name="dataInsert")
     * @Method({"POST"})
     */
    public function dataInsertAction(Request $request)
    {
        $timestamp = new \DateTime();
        $beaconId = $request->request->get('beaconId','not available');
        $feeling = $request->request->get('feeling','no feeling');
        $happening = $request->request->get('happening','no happening');

        $entityManager = $this->getDoctrine()->getManager();
        $incident = new Incident();
        $incident->setTimestamp($timestamp);
        $incident->setBeaconId($beaconId);
        $incident->setFeeling($feeling);
        $incident->setHappening($happening);
        $entityManager->persist($incident);
        $entityManager->flush();

        return $this->json([
            'timestamp' => $timestamp,
            'beaconId' => $beaconId,
            'feeling' => $feeling,
            'happening' => $happening
        ]);
    }

    /**
     * @Route("/bvg/data_output", name="dataOutput")
     */
    public function dataOutputAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $incidents = $entityManager->getRepository(Incident::class)->findBy([],['timestamp' => 'DESC'],10);

        $incidentsArray = [];

        foreach ($incidents as $incident) {
            $incidentsArray[] = [
                'timestamp' => $incident->getTimestamp()->format("c"),
                'beaconId' => $incident->getBeaconId(),
                'feeling' => $incident->getFeeling(),
                'happening' => $incident->getHappening()
            ];
        }

        return $this->json($incidentsArray);
    }
}
