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
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

class SendLabelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $user;
    protected $attributes;
    protected $weight = 0;
    protected $peices = 0;
    public $shipmentNumber;

    private function aramexMagicDate($date)
    {
        $tz = 2 * 100;
        $tz = $tz > 0 ? "-$tz" : "+$tz";
        return '/Date(' . (\Carbon\Carbon::parse($date)->timestamp) * 1000 . $tz . ')/';
    }
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->attributes['payload']['order']['purchases'] as $item) {
            $this->weight += $item['dimensions']['weight']['value'] * $item['quantity'];
            $this->peices += $item['quantity'];
        }

        $this->user = User::where('email', $this->attributes['meta']['tenant']['owner']['email'])->first();
        if (!$this->user) {
            return response('User Not Found', 404);
        }


        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreateShipments', [

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
                            "PartyAddress" => [
                                "Line1" => $this->attributes['payload']['order']['shipping_address']['line1'],
                                "Line2" => "",
                                "Line3" => "",
                                "City" => $this->attributes['payload']['order']['shipping_address']['city'],
                                "StateOrProvinceCode" => "",
                                "PostCode" => "",
                                "CountryCode" => $this->attributes['payload']['order']['shipping_address']['country'],
                                "Longitude" => $this->attributes['payload']['order']['shipments'][0]['source']['lng'] ?? 0,
                                "Latitude" =>  $this->attributes['payload']['order']['shipments'][0]['source']['lat'] ?? 0,
                                "BuildingNumber" => null,
                                "BuildingName" => null,
                                "Floor" => null,
                                "Apartment" => null,
                                "POBox" => null,
                                "Description" => null,
                            ],
                            "Contact" => [
                                "Department" => "",
                                "PersonName" => $this->attributes['payload']['order']['shipping_address']['name'],
                                "Title" => "",
                                "CompanyName" => $this->attributes['payload']['details']['company_name'],
                                "PhoneNumber1" => $this->attributes['payload']['order']['shipping_address']['telephone'],
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => $this->attributes['payload']['order']['shipping_address']['telephone'],
                                "EmailAddress" =>  $this->attributes['meta']['tenant']['owner']['email'],
                                "Type" => ""
                            ]
                        ],
                        "Consignee" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => "",
                            "PartyAddress" => [
                                "Line1" => $this->attributes['payload']['order']['shipments'][0]['destination']['line1'],
                                "Line2" => $this->attributes['payload']['order']['shipments'][0]['destination']['line2'],
                                "Line3" => "",
                                "City" => $this->attributes['payload']['order']['shipments'][0]['destination']['city'],
                                "StateOrProvinceCode" => "",
                                "PostCode" => "",
                                "CountryCode" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'],
                                "Longitude" => $this->attributes['payload']['order']['shipments'][0]['destination']['lng'] ?? 0,
                                "Latitude" => $this->attributes['payload']['order']['shipments'][0]['destination']['lat'] ?? 0,
                                "BuildingNumber" => "",
                                "BuildingName" => "",
                                "Floor" => "",
                                "Apartment" => "",
                                "POBox" => null,
                                "Description" => ""
                            ],
                            "Contact" => [
                                "Department" => "",
                                "PersonName" => $this->attributes['payload']['order']['shipments'][0]['destination']['name'],
                                "Title" => "",
                                "CompanyName" => $this->attributes['payload']['order']['shipments'][0]['destination']['name'],
                                "PhoneNumber1" => $this->attributes['payload']['order']['shipments'][0]['destination']['telephone'],
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => $this->attributes['payload']['order']['shipments'][0]['destination']['telephone'],
                                "EmailAddress" => $this->attributes['payload']['order']['shipments'][0]['destination']['email'],
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
                        "ShippingDateTime" => $this->aramexMagicDate(now()),
                        "DueDate" => $this->aramexMagicDate(now()->addDay()),
                        "PickupLocation" => "",
                        "OperationsInstructions" => "",
                        "AccountingInstrcutions" => "",
                        "Details" => [
                            "Dimensions" => null,
                            "ActualWeight" => [
                                "Unit" => "KG",
                                "Value" => $this->weight,
                            ],
                            "ChargeableWeight" => null,
                            "DescriptionOfGoods" => $this->attributes['payload']['details']['goods_description'],
                            "GoodsOriginCountry" => $this->attributes['payload']['details']['country_of_origin'],
                            "NumberOfPieces" => $this->peices,
                            "ProductGroup" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "DOM",
                            "ProductType" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "OND" : "OND",
                            "PaymentType" => "P", #$this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "C" : "P",
                            "PaymentOptions" => "", #$this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "ASCC" : "",
                            "CustomsValueAmount" => null,
                            "CashOnDeliveryAmount" => null, #$this->attributes['payload']['order']['total']['amount'],
                            "InsuranceAmount" => null,
                            "CashAdditionalAmount" => null,
                            "CashAdditionalAmountDescription" => "Please ss",
                            "CollectAmount" => null,
                            "Services" => "", #$this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "CODS" : "",
                            "Items" => []
                        ],
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
                        "Line1" => $this->attributes['payload']['order']['shipping_address']['line1'],
                        "Line2" => "",
                        "Line3" => "",
                        "City" =>  $this->attributes['payload']['order']['shipping_address']['city'],
                        "StateOrProvinceCode" => "",
                        "PostCode" => "",
                        "CountryCode" => $this->attributes['payload']['order']['shipping_address']['country'],
                        "Longitude" => $this->attributes['payload']['order']['shipments'][0]['source']['lng'] ?? 0,
                        "Latitude" => $this->attributes['payload']['order']['shipments'][0]['source']['lat'] ?? 0,
                        "BuildingNumber" => null,
                        "BuildingName" => null,
                        "Floor" => null,
                        "Apartment" => null,
                        "POBox" => null,
                        "Description" => null
                    ],
                    "PickupContact" => [
                        "Department" => "",
                        "PersonName" => $this->attributes['payload']['order']['shipping_address']['name'],
                        "Title" => "",
                        "CompanyName" => $this->attributes['payload']['details']['company_name'],
                        "PhoneNumber1" => $this->attributes['payload']['order']['shipping_address']['telephone'],
                        "PhoneNumber1Ext" => "",
                        "PhoneNumber2" => "",
                        "PhoneNumber2Ext" => "",
                        "FaxNumber" => "",
                        "CellPhone" => $this->attributes['payload']['order']['shipping_address']['telephone'],
                        "EmailAddress" =>  $this->attributes['meta']['tenant']['owner']['email'],
                        "Type" => ""
                    ],
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
                                    "Line1" => $this->attributes['payload']['order']['shipments'][0]['destination']['line1'],
                                    "Line2" => $this->attributes['payload']['order']['shipments'][0]['destination']['line2'],
                                    "Line3" => "",
                                    "City" => $this->attributes['payload']['order']['shipments'][0]['destination']['city'],
                                    "StateOrProvinceCode" => "",
                                    "PostCode" => "",
                                    "CountryCode" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'],
                                    "Longitude" => $this->attributes['payload']['order']['shipments'][0]['destination']['lng'] ?? 0,
                                    "Latitude" => $this->attributes['payload']['order']['shipments'][0]['destination']['lat'] ?? 0,
                                    "BuildingNumber" => "",
                                    "BuildingName" => "",
                                    "Floor" => "",
                                    "Apartment" => "",
                                    "POBox" => null,
                                    "Description" => ""
                                ],
                                "Contact" => [
                                    "Department" => "",
                                    "PersonName" => $this->attributes['payload']['order']['shipments'][0]['destination']['name'],
                                    "Title" => "",
                                    "CompanyName" => $this->attributes['payload']['order']['shipments'][0]['destination']['name'],
                                    "PhoneNumber1" => $this->attributes['payload']['order']['shipments'][0]['destination']['telephone'],
                                    "PhoneNumber1Ext" => "",
                                    "PhoneNumber2" => "",
                                    "PhoneNumber2Ext" => "",
                                    "FaxNumber" => "",
                                    "CellPhone" => $this->attributes['payload']['order']['shipments'][0]['destination']['telephone'],
                                    "EmailAddress" => $this->attributes['payload']['order']['shipments'][0]['destination']['email'],
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
                            "ShippingDateTime" => $this->aramexMagicDate(now()),
                            "DueDate" =>$this->aramexMagicDate(now()),
                            "Comments" => "Comments ...",
                            "PickupLocation" => "Reception",
                            "OperationsInstructions" => "Fragile",
                            "AccountingInstrcutions" => "Get us a discount please",
                            "Details" => [
                                "Dimensions" => null,
                                "ActualWeight" => [
                                    "Unit" => "KG",
                                    "Value" => $this->weight,
                                ],
                                "ChargeableWeight" => null,
                                "DescriptionOfGoods" => $this->attributes['payload']['details']['goods_description'],
                                "GoodsOriginCountry" => $this->attributes['payload']['details']['country_of_origin'],
                                "NumberOfPieces" => $this->peices,
                                "ProductGroup" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "DOM",
                                "ProductType" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "OND" : "OND",
                                "PaymentType" => "P", #$this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "C" : "P",
                                "PaymentOptions" => "", #$this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "ASCC" : "",
                                "CustomsValueAmount" => null,
                                "CashOnDeliveryAmount" => null, #$this->attributes['payload']['order']['total']['amount'],
                                "InsuranceAmount" => null,
                                "CashAdditionalAmount" => null,
                                "CashAdditionalAmountDescription" => "Please ss",
                                "CollectAmount" => null,
                                "Services" => "", #$this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "CODS" : "",
                                "Items" => []
                            ],
                            "Attachments" => [],
                            "ForeignHAWB" => $hwab,
                            "TransportType " => 0,
                            "PickupGUID" => null,
                            "Number" => "",
                            "ScheduledDelivery" => null
                        ]
                    ],

                    "PickupItems" => [
                        [
                            "ProductGroup" =>  $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "DOM",
                            "ProductType" => "OND",
                            "NumberOfShipments" => $this->peices,
                            "PackageType" => "Box",
                            "Payment" => "P",
                            "ShipmentWeight" => [
                                "Unit" => "KG",
                                "Value" => $this->weight
                            ],
                            "ShipmentVolume" => null,
                            "NumberOfPieces" => $this->peices,
                            "CashAmount" => null,
                            "ExtraCharges" => null,
                            "ShipmentDimensions" => [
                                "Length"=> 0,
                                "Width"=> 0,
                                "Height"=> 0,
                                "Unit"=> "CM"
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

            logger($response);

            $this->sendLabel();
        } catch (\Exception $e) {
            throw new Exception('Not passed!');
        }
    }

    public function sendLabel()
    {
        try {
            $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/PrintLabel', [
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
