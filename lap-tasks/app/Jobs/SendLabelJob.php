<?php

namespace App\Jobs;

use App\Mail\SendLabel;
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

class SendLabelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shipmentId;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shipmentId,User $user)
    {
        $this->shipmentId = $shipmentId;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/PrintLabel', [
                [
                    "ClientInfo"=> [
                        "UserName" => $this->user->email,
                        "Password" => $this->user->password,
                        "Version" => $this->user->version,
                        "AccountNumber" => $this->user->accountNumber,
                        "AccountPin" => $this->user->accountPin,
                        "AccountEntity" => $this->user->accountEntity,
                        "AccountCountryCode" => $this->user->accountCountryCode,
                        "Source" => $this->user->source
                    ],
                    "LabelInfo"=> [
                        "ReportID"=> 9201,
                        "ReportType"=> "URL"
                    ],
                    "OriginEntity"=> "AMM",
                    "ProductGroup"=> "EXP",
                    "ShipmentNumber"=> "3958011433",
                    "Transaction"=> [
                        "Reference1"=> "",
                        "Reference2"=> "",
                        "Reference3"=> "",
                        "Reference4"=> "",
                        "Reference5"=> ""
                    ]
                ]
            ]);

            Mail::to($this->user->email)->send(new SendLabel($this->shipmentId));

            $this->createPickup($response['ShipmentNumber']);
        } catch (Exception $e) {
            throw new Exception('Not passed');
        }
    }

    private function createPickup($shipmentNumber)
    {
        try {


            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup', [
                "ClientInfo" => [
                    "UserName" => $this->user->email,
                    "Password" => $this->user->password,
                    "Version" => $this->user->version,
                    "AccountNumber" => $this->user->accountNumber,
                    "AccountPin" => $this->user->accountPin,
                    "AccountEntity" => $this->user->accountEntity,
                    "AccountCountryCode" => $this->user->accountCountryCode,
                    "Source" => $this->user->source
                ],
                "LabelInfo" => [
                    "ReportID" => 9201,
                    "ReportType" => "URL"
                ],
                "Pickup" => [
                    "PickupAddress" => [
                        "Line1" => "Test",
                        "Line2" => "",
                        "Line3" => "",
                        "City" => "Amman",
                        "StateOrProvinceCode" => "",
                        "PostCode" => "",
                        "CountryCode" => "JO",
                        "Longitude" => 0,
                        "Latitude" => 0,
                        "BuildingNumber" => null,
                        "BuildingName" => null,
                        "Floor" => null,
                        "Apartment" => null,
                        "POBox" => null,
                        "Description" => null
                    ],
                    "PickupContact" => [
                        "Department" => "",
                        "PersonName" => "test",
                        "Title" => "",
                        "CompanyName" => "test",
                        "PhoneNumber1" => "1111111111111",
                        "PhoneNumber1Ext" => "",
                        "PhoneNumber2" => "",
                        "PhoneNumber2Ext" => "",
                        "FaxNumber" => "",
                        "CellPhone" => "11111111111111",
                        "EmailAddress" => "test@test.com",
                        "Type" => ""
                    ],
                    "PickupLocation" => "test",
                    "PickupDate" => "\/Date(1484096770000-0500)\/",
                    "ReadyTime" => "\/Date(1484078770000-0500)\/",
                    "LastPickupTime" => "\/Date(1484085970000-0500)\/",
                    "ClosingTime" => "\/Date(1484089570000-0500)\/",
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
                                "AccountNumber" => $this->user->accountNumber,
                                "PartyAddress" => [
                                    "Line1" => "Test",
                                    "Line2" => "",
                                    "Line3" => "",
                                    "City" => "Amman",
                                    "StateOrProvinceCode" => "",
                                    "PostCode" => "",
                                    "CountryCode" => "JO",
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
                                    "PersonName" => "Test",
                                    "Title" => "",
                                    "CompanyName" => "Test",
                                    "PhoneNumber1" => "5555",
                                    "PhoneNumber1Ext" => "",
                                    "PhoneNumber2" => "",
                                    "PhoneNumber2Ext" => "",
                                    "FaxNumber" => "",
                                    "CellPhone" => "5555",
                                    "EmailAddress" => "m@m.com",
                                    "Type" => ""
                                ]
                            ],
                            "Consignee" => [
                                "Reference1" => "",
                                "Reference2" => "",
                                "AccountNumber" => "",
                                "PartyAddress" => [
                                    "Line1" => "Test",
                                    "Line2" => "",
                                    "Line3" => "",
                                    "City" => "Dubai",
                                    "StateOrProvinceCode" => "",
                                    "PostCode" => "",
                                    "CountryCode" => "AE",
                                    "Longitude" => 0,
                                    "Latitude" => 0,
                                    "BuildingNumber" => "",
                                    "BuildingName" => "",
                                    "Floor" => "",
                                    "Apartment" => "",
                                    "POBox" => null,
                                    "Description" => ""
                                ],
                                "Contact" => [
                                    "Department" => "",
                                    "PersonName" => "Test",
                                    "Title" => "",
                                    "CompanyName" => "Test",
                                    "PhoneNumber1" => "555",
                                    "PhoneNumber1Ext" => "",
                                    "PhoneNumber2" => "",
                                    "PhoneNumber2Ext" => "",
                                    "FaxNumber" => "",
                                    "CellPhone" => "555",
                                    "EmailAddress" => "f@f.com",
                                    "Type" => ""
                                ]
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
                            "ShippingDateTime" => "\/Date(1484096858000-0500)\/",
                            "DueDate" => "\/Date(1484096858000-0500)\/",
                            "Comments" => "Comments ...",
                            "PickupLocation" => "Reception",
                            "OperationsInstructions" => "Fragile",
                            "AccountingInstrcutions" => "Get us a discount please",
                            "Details" => [
                                "Dimensions" => null,
                                "ActualWeight" => [
                                    "Unit" => "KG",
                                    "Value" => 0.5
                                ],
                                "ChargeableWeight" => null,
                                "DescriptionOfGoods" => "Docs",
                                "GoodsOriginCountry" => "JO",
                                "NumberOfPieces" => 1,
                                "ProductGroup" => "EXP",
                                "ProductType" => "PDX",
                                "PaymentType" => "P",
                                "PaymentOptions" => "",
                                "CustomsValueAmount" => null,
                                "CashOnDeliveryAmount" => null,
                                "InsuranceAmount" => null,
                                "CashAdditionalAmount" => null,
                                "CashAdditionalAmountDescription" => "",
                                "CollectAmount" => null,
                                "Services" => "",
                                "Items" => [],
                                "DeliveryInstructions" => null
                            ],
                            "Attachments" => [],
                            "ForeignHAWB" => "12212121212121",
                            "TransportType " => 0,
                            "PickupGUID" => null,
                            "Number" => "",
                            "ScheduledDelivery" => null
                        ]
                    ],
                    "PickupItems" => [
                        [
                            "ProductGroup" => "EXP",
                            "ProductType" => "PDX",
                            "NumberOfShipments" => 1,
                            "PackageType" => "Box",
                            "Payment" => "P",
                            "ShipmentWeight" => [
                                "Unit" => "KG",
                                "Value" => 0.5
                            ],
                            "ShipmentVolume" => null,
                            "NumberOfPieces" => 1,
                            "CashAmount" => null,
                            "ExtraCharges" => null,
                            "ShipmentDimensions" => [
                                "Length" => 0,
                                "Width" => 0,
                                "Height" => 0,
                                "Unit" => ""
                            ],
                            "Comments" => "Test"
                        ]
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

        } catch (\Exception $e) {
            throw new Exception('Not passed!');
        }
    }
}
