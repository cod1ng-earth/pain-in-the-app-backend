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
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function dataInsertAction(Request $request)
    {
        $timestamp = new \DateTime();
        $beaconId = $request->request->get('beaconId','not available');
        $trip = $request->request->get('trip','no trip');
        $wagon = $request->request->get('wagon','no wagon');
        $feeling = $request->request->get('feeling','no feeling');
        $happening = $request->request->get('happening','no happening');

        $incident = new Incident();
        $incident->setTimestamp($timestamp);
        $incident->setBeaconId($beaconId);
        $incident->setTrip($trip);
        $incident->setWagon($wagon);
        $incident->setFeeling($feeling);
        $incident->setHappening($happening);
        $this->getDoctrine()->getManager()->persist($incident);
        $this->getDoctrine()->getManager()->flush();

        return $this->json([
            'timestamp' => $timestamp,
            'beaconId' => $beaconId,
            'trip' => $trip,
            'wagon' => $wagon,
            'feeling' => $feeling,
            'happening' => $happening
        ]);
    }

    /**
     * @Route("/bvg/data_output", name="DataOutput")
     */
    public function dataOutputAction()
    {
        $incidents = $this->getDoctrine()
            ->getRepository(Incident::class)
            ->findBy([],['timestamp' => 'DESC'],10);

        $incidentsArray = [];

        foreach ($incidents as $incident) {
            $incidentsArray[] = [
                'timestamp' => $incident->getTimestamp()->format("c"),
                'beaconId' => $incident->getBeaconId(),
                'trip' => $incident->getTrip(),
                'wagon' => $incident->getWagon(),
                'feeling' => $incident->getFeeling(),
                'happening' => $incident->getHappening()
            ];
        }

        return $this->json($incidentsArray);
    }

    /**
     * @Route("/bvg/data_output/one_beacon", name="DataOutputOneBeacon")
     * @Method({"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function dataOutputOneBeaconAction(Request $request)
    {
        $beaconId = $request->request->get('beaconId',0);

        $incidents = $this->getDoctrine()
            ->getRepository(Incident::class)
            ->findByBeacon($beaconId);

        $incidentsArray = [];

        foreach ($incidents as $incident) {
                $incidentsArray[] = [
                    'timestamp' => $incident->getTimestamp()->format("c"),
                    'beaconId' => $incident->getBeaconId(),
                    'trip' => $incident->getTrip(),
                    'wagon' => $incident->getWagon(),
                    'feeling' => $incident->getFeeling(),
                    'happening' => $incident->getHappening()
                ];
        }

        return $this->json($incidentsArray);
    }
}
