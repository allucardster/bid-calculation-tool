<?php

namespace App\Tests\ApiResource;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\ApiResource\VehicleBid;
use App\Model\Fee;
use App\Model\FeeTypeEnum;
use App\Model\Vehicle;
use App\Model\VehicleTypeEnum;

final class VehicleBidTest extends ApiTestCase
{
    /**
     * @group unit
     */
    public function testGetTotalFromVehicleBid(): void
    {
        $vehicle = new Vehicle(398, VehicleTypeEnum::COMMON);
        $fees = [
            new Fee(FeeTypeEnum::BASIC, 39.80),
            new Fee(FeeTypeEnum::SPECIAL, 7.96),
            new Fee(FeeTypeEnum::ASSOCIATION, 5),
            new Fee(FeeTypeEnum::STORAGE, 100),
        ];
        $vehicleBid = new VehicleBid($vehicle, $fees);
        $this->assertEquals(550.76, $vehicleBid->getTotal());
    }

    /**
     * @group api
     */
    public function testPostApiVehicleBid(): void
    {
        $vehicleBids = [
            [
                'vehicle' => [
                    'price' => 398,
                    'type' => VehicleTypeEnum::COMMON,
                ],
                'fees' => [
                    ['type' => FeeTypeEnum::ASSOCIATION, 'value' => 5],
                    ['type' => FeeTypeEnum::BASIC, 'value' => 39.800000000000004],
                    ['type' => FeeTypeEnum::SPECIAL, 'value' => 7.96],
                    ['type' => FeeTypeEnum::STORAGE, 'value' => 100],
                ],
                'total' => 550.76
            ],
            [
                'vehicle' => [
                    'price' => 501,
                    'type' => VehicleTypeEnum::COMMON,
                ],
                'fees' => [
                    ['type' => FeeTypeEnum::ASSOCIATION, 'value' => 10],
                    ['type' => FeeTypeEnum::BASIC, 'value' => 50],
                    ['type' => FeeTypeEnum::SPECIAL, 'value' => 10.02],
                    ['type' => FeeTypeEnum::STORAGE, 'value' => 100],
                ],
                'total' => 671.02
            ],
            [
                'vehicle' => [
                    'price' => 57,
                    'type' => VehicleTypeEnum::COMMON,
                ],
                'fees' => [
                    ['type' => FeeTypeEnum::ASSOCIATION, 'value' => 5],
                    ['type' => FeeTypeEnum::BASIC, 'value' => 10],
                    ['type' => FeeTypeEnum::SPECIAL, 'value' => 1.1400000000000001],
                    ['type' => FeeTypeEnum::STORAGE, 'value' => 100],
                ],
                'total' => 173.14
            ],
            [
                'vehicle' => [
                    'price' => 1800,
                    'type' => VehicleTypeEnum::LUXURY
                ],
                'fees' => [
                    ['type' => FeeTypeEnum::ASSOCIATION, 'value' => 15],
                    ['type' => FeeTypeEnum::BASIC, 'value' => 180],
                    ['type' => FeeTypeEnum::SPECIAL, 'value' => 72],
                    ['type' => FeeTypeEnum::STORAGE, 'value' => 100],
                ],
                'total' => 2167
            ],
            [
                'vehicle' => [
                    'price' => 1100,
                    'type' => VehicleTypeEnum::COMMON,
                ],
                'fees' => [
                    ['type' => FeeTypeEnum::ASSOCIATION, 'value' => 15],
                    ['type' => FeeTypeEnum::BASIC, 'value' => 50],
                    ['type' => FeeTypeEnum::SPECIAL, 'value' => 22],
                    ['type' => FeeTypeEnum::STORAGE, 'value' => 100],
                ],
                'total' => 1287
            ],
            [
                'vehicle' => [
                    'price' => 1000000,
                    'type' => VehicleTypeEnum::LUXURY
                ],
                'fees' => [
                    ['type' => FeeTypeEnum::ASSOCIATION, 'value' => 20],
                    ['type' => FeeTypeEnum::BASIC, 'value' => 200],
                    ['type' => FeeTypeEnum::SPECIAL, 'value' => 40000],
                    ['type' => FeeTypeEnum::STORAGE, 'value' => 100],
                ],
                'total' => 1040320
            ],
        ];

        $client = static::createClient([], ['headers' => ['accept' => ['application/json']]]);
        foreach ($vehicleBids as $vehicleBid) {
            $client->request('POST', '/api/vehicle_bids', ['json' => [
                'vehiclePrice' => $vehicleBid['vehicle']['price'],
                'vehicleType' => $vehicleBid['vehicle']['type'],
            ]]);

            $this->assertResponseIsSuccessful();
            $this->assertJsonEquals(json_encode($vehicleBid));
        }
    }
}