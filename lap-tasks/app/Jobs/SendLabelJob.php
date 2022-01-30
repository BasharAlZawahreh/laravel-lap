<?php

namespace App\Jobs;

use App\Mail\SendLabel;
use App\Models\Shipment;
use App\Models\Shopper;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

class SendLabelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user;
    protected $attributes;
    protected $weight = 0;
    protected $peices = 0;

    public $shipmentNumber;
    public $clientInfo;
    public $shopAddress;
    public $shopContact;

    public $shopperAddress;
    public $shopperContact;

    public $shipmentDetails;
    public $pickupItems;

    private function aramexMagicDate($date)
    {
        $tz = 2 * 100;
        $tz = $tz > 0 ? "-$tz" : "+$tz";
        return '/Date(' . (\Carbon\Carbon::parse($date)->timestamp) * 1000 . $tz . ')/';
    }


    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        $this->clientInfo = User::getUserInfo($attributes['meta']['tenant']['owner']['email']);
        $this->shopAddress = User::getShopAddress($attributes);
        $this->shopContact = User::getShopContact($attributes);

        $this->shopperAddress = Shopper::getShopperAddress($attributes);
        $this->shopperContact = Shopper::getShopperContact($attributes);

        $this->shipmentDetails = Shipment::getShipmentDetails($attributes);
        $this->pickupItems = Shipment::getPickupItems($attributes);
    }


    public function handle()
    {



        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreateShipments', [

                "ClientInfo" => $this->clientInfo,
                "LabelInfo" => null,
                "Shipments" => [
                    [
                        "Reference1" => "",
                        "Reference2" => "",
                        "Reference3" => "",
                        "Shipper" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => $this->user->accountNumber,
                            "PartyAddress" => $this->shopAddress,
                            "Contact" => $this->shopContact,
                        ],
                        "Consignee" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => "",
                            "PartyAddress" => $this->shopperAddress,
                            "Contact" => $this->shopperContact,
                        ],
                        "ThirdParty" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => "",
                            "PartyAddress" => [
                                "Line1" => "",
                                "Line2" => "",
                                "Line3" => "",
                                "City" => "",
                                "StateOrProvinceCode" => "",
                                "PostCode" => "",
                                "CountryCode" => "",
                                "Longitude" => 0,
                                "Latitude" => 0,
                                "BuildingNumber" => null,
                                "BuildingName" => null,
                                "Floor" => null,
                                "Apartment" => null,
                                "POBox" => null,
                                "Description" => null
                            ],
                            "Contact" => [
                                "Department" => "",
                                "PersonName" => "",
                                "Title" => "",
                                "CompanyName" => "",
                                "PhoneNumber1" => "",
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => "",
                                "EmailAddress" => "",
                                "Type" => ""
                            ]
                        ],
                        "ShippingDateTime" => $this->aramexMagicDate(now()),
                        "DueDate" => $this->aramexMagicDate(now()->addDay()),
                        "PickupLocation" => "",
                        "OperationsInstructions" => "",
                        "AccountingInstrcutions" => "",
                        "Details" => $this->shipmentDetails,
                        "Attachments" => [],
                        "ForeignHAWB" => "",
                        "TransportType " => 0,
                        "PickupGUID" => "",
                        "Number" => null,
                        "ScheduledDelivery" => null
                    ]
                ],
                "Transaction" => [
                    "Reference1" => "",
                    "Reference2" => "",
                    "Reference3" => "",
                    "Reference4" => "",
                    "Reference5" => ""
                ]
            ]);

            $this->shipmentNumber = $response->json('Shipments')[0]['ID'];

            $this->createPickup($response->json('Shipments')[0]['ForeignHAWB']);

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    private function createPickup($hwab)
    {
        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup', [
                "ClientInfo" => $this->clientInfo,
                "LabelInfo" => [
                    "ReportID" => 9201,
                    "ReportType" => "URL"
                ],
                "Pickup" => [
                    "PickupAddress" => $this->shopAddress,
                    "PickupContact" => $this->shopContact,
                    "PickupLocation" => "test",
                    "PickupDate" => $this->aramexMagicDate(now()->addDay()),
                    "ReadyTime" => $this->aramexMagicDate(now()),
                    "LastPickupTime" => $this->aramexMagicDate(now()->addDay()),
                    "ClosingTime" => $this->aramexMagicDate(now()->addDay()),
                    "Comments" => "",
                    "Reference1" => "001",
                    "Reference2" => "",
                    "Vehicle" => "",
                    "Shipments" => [
                        [
                            "Reference1" => "123",
                            "Reference2" => "",
                            "Reference3" => "",
                            "Shipper" => [
                                "Reference1" => "",
                                "Reference2" => "",
                                "AccountNumber" => $this->clientInfo['AccountNumber'],
                                "PartyAddress" => $this->shopAddress,
                                "Contact" => $this->shopContact
                            ],
                            "Consignee" => [
                                "Reference1" => "",
                                "Reference2" => "",
                                "AccountNumber" => "",
                                "PartyAddress" => $this->shopperContact,
                                "Contact" => $this->shopperContact
                            ],
                            "ThirdParty" => [
                                "Reference1" => "",
                                "Reference2" => "",
                                "AccountNumber" => "",
                                "PartyAddress" => [
                                    "Line1" => "",
                                    "Line2" => "",
                                    "Line3" => "",
                                    "City" => "",
                                    "StateOrProvinceCode" => "",
                                    "PostCode" => "",
                                    "CountryCode" => "",
                                    "Longitude" => 0,
                                    "Latitude" => 0,
                                    "BuildingNumber" => null,
                                    "BuildingName" => null,
                                    "Floor" => null,
                                    "Apartment" => null,
                                    "POBox" => null,
                                    "Description" => null
                                ],
                                "Contact" => [
                                    "Department" => "",
                                    "PersonName" => "",
                                    "Title" => "",
                                    "CompanyName" => "",
                                    "PhoneNumber1" => "",
                                    "PhoneNumber1Ext" => "",
                                    "PhoneNumber2" => "",
                                    "PhoneNumber2Ext" => "",
                                    "FaxNumber" => "",
                                    "CellPhone" => "",
                                    "EmailAddress" => "",
                                    "Type" => ""
                                ]
                            ],
                            "ShippingDateTime" => $this->aramexMagicDate(now()),
                            "DueDate" =>$this->aramexMagicDate(now()),
                            "Comments" => "Comments ...",
                            "PickupLocation" => "Reception",
                            "OperationsInstructions" => "Fragile",
                            "AccountingInstrcutions" => "Get us a discount please",
                            "Details" => $this->shipmentDetails,
                            "Attachments" => [],
                            "ForeignHAWB" => $hwab,
                            "TransportType " => 0,
                            "PickupGUID" => null,
                            "Number" => "",
                            "ScheduledDelivery" => null
                        ]
                    ],

                    "PickupItems" => [
                       $this->pickupItems
                    ],
                    "Status" => "Ready",
                    "ExistingShipments" => null,
                    "Branch" => "",
                    "RouteCode" => ""
                ],
                "Transaction" => [
                    "Reference1" => "",
                    "Reference2" => "",
                    "Reference3" => "",
                    "Reference4" => "",
                    "Reference5" => ""
                ]
            ]);


            $this->sendLabel();

        } catch (\Exception $e) {
            throw new Exception('Not passed!');
        }
    }

    public function sendLabel()
    {
        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/PrintLabel', [
                "ClientInfo" => $this->clientInfo,
                "LabelInfo" => [
                    "ReportID" => 9201,
                    "ReportType" => "URL"
                ],
                "OriginEntity" => $this->attributes['payload']['details']['country_of_origin'],
                "ProductGroup" =>  $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "DOM",
                "ShipmentNumber" => $this->shipmentNumber,
                "Transaction" => [
                    "Reference1" => "",
                    "Reference2" => "",
                    "Reference3" => "",
                    "Reference4" => "",
                    "Reference5" => ""
                ],
            ]);

            

            Mail::to($this->user->email)
                ->send(new SendLabel($response->json('ProcessedPickup')['ProcessedShipments'][0]['ShipmentLabel']['LabelURL']));

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
