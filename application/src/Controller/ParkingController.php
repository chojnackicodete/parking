<?php
declare(strict_types=1);

namespace App\Controller;
use App\Model\DTO\ParkingStatusDTO;
use App\Repository\ParkingRepository;
use App\Service\ParkingEntityHandler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use App\Service\ParkingManager;

/**
 *Parking controller
 *@Route("/api",name="api_")
 */
class ParkingController extends AbstractFOSRestController
{
    private ParkingManager $parkingManager;
    private ParkingEntityHandler $parkingEntityHandler;


    public function __construct(ParkingManager $parkingManager, ParkingEntityHandler $parkingEntityHandler)
    {
        $this->parkingManager = $parkingManager;
        $this->parkingEntityHandler = $parkingEntityHandler;

    }

    /**
     * Create Parking
     * @Rest\Post("/parking", name="parking_create")
     * @OA\Response(
     *     response=200,
     *     description="created succesfuly"
     * )
     * @OA\Parameter(
     *     name="name",
     *     in="query",
     *     description="Parking name",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="rowAmount",
     *     in="query",
     *     description="Amount of parking rows",
     *     @OA\Schema(type="integer")
     * )
     * @OA\Parameter(
     *     name="slotPerRowAmount",
     *     in="query",
     *     description="Amount of parking slots per row",
     *     @OA\Schema(type="integer")
     * )
     * @return Response
     */
    public function createParkingAction(Request $request): Response
    {
        $name = $request->get('name');
        $rowAmount = (int)$request->get('rowAmount');
        $slotPerRowAmount = (int)$request->get('slotPerRowAmount');

        $parking = $this->parkingManager->createParking($name, $rowAmount, $slotPerRowAmount);

        if ($this->parkingEntityHandler->persistParking($parking)){
            return $this->handleView($this->view(['status'=>'ok', 'parking_id' => $parking->getEntity()->getId()], Response::HTTP_CREATED));
        } else {
            return $this->handleView($this->view(['status'=>'fail'], Response::HTTP_BAD_REQUEST));
        }
    }

    /**
     * Park car
     * @Rest\Post("/parking/{id}/park-vehicle", name="parking_park")
     *  @OA\Parameter(
     *     name="plateNo",
     *     in="query",
     *     description="vehicle plate no",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="type",
     *     in="query",
     *     description="type of vehicle, one of ['car', 'bus', 'motorcycle']",
     *     @OA\Schema(type="integer")
     * )
     * @return Response
     */
    public function parkVehicleAction(int $id, Request $request)
    {
        $plateNo = $request->get('plateNo');
        $type = $request->get('type');

        if (($slot = $this->parkingManager->parkVehicle($id, $type, $plateNo))){
            $place = sprintf('%s/%s', $slot->getParkingRow()->getAlpha(), $slot->getNumber());
            return $this->handleView($this->view(['status'=>'ok', 'row/slot' => $place], Response::HTTP_CREATED));
        } else {
            return $this->handleView($this->view(['status'=>'fail', 'message' => 'parking is full'], Response::HTTP_BAD_REQUEST));
        }
    }

    /**
     * Depart car
     * @Rest\Post("/parking/{id}/depart-vehicle", name="parking_depart")
     * @OA\Parameter(
     *     name="plateNo",
     *     in="query",
     *     description="vehicle plate no",
     *     @OA\Schema(type="string")
     * )
     * @return Response
     */
    public function departVehicleAction(int $id, Request $request)
    {
        $plateNo = $request->get('plateNo');
        $status = $this->parkingManager->departVehicle($id, $plateNo);

        if ($status) {
            return $this->handleView($this->view(['status'=>'ok', 'message' => 'car departed'], Response::HTTP_CREATED));
        } else {
            return $this->handleView($this->view(['status'=>'fail', 'message' => 'car not found'], Response::HTTP_BAD_REQUEST));
        }
    }

    /**
     * Display parking status
     * @Rest\Get("/parking/status/{id}", name="parking_status")
     * @return Response
     */
    public function getParkingStatusAction(int $id)
    {
        $parkingModel = $this->parkingEntityHandler->loadFromDb($id);
        $parkingDTO = new ParkingStatusDTO($parkingModel);
        return $this->handleView($this->view($parkingDTO, Response::HTTP_CREATED));
    }

}
