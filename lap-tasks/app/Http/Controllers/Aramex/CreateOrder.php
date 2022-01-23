<?php

namespace App\Http\Controllers\Aramex;

use App\Http\Controllers\Controller;
use App\Jobs\SendLabelJob;
use App\Models\User;
use Attribute;
use Carbon\Carbon;
use DateTimeInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class CreateOrder extends Controller
{
    protected $user;
    protected $attributes;
    protected $weight = 0;
    protected $peices = 0;

    public function create()
    {
        $this->attributes = request()->validate([
            'meta.tenant.owner.email' => 'required|email',
            'payload.order.shipping_address.line1' => 'required|string|max=>255',
            'payload.order.shipping_address.line2' => 'nullable|string|max:255',
            'payload.order.shipping_address.city' => 'required|string',
            'payload.order.shipping_address.country' => 'required|string',
            'payload.order.shipments.0.source.lng' => 'nullable|string',
            'payload.order.shipments.0.source.lat' => 'nullable|string',
            'payload.order.shipping_address.name' => 'nullable|string',
            'payload.order.shipping_address.telephone' => 'nullable|string',
            'payload.details.company_name' => 'required|string',

            'payload.order.total.amount' => 'required|numeric',
            'payload.order.payment_method' => 'required|string',

            'payload.order.shipments.0.destination.line1' => 'required|string',
            'payload.order.shipments.0.destination.line2' => 'nullable|string',
            'payload.order.shipments.0.destination.city' => 'required|string',
            'payload.order.shipments.0.destination.country' => 'required|string',
            'payload.order.shipments.0.destination.lng' => 'nullable|string',
            'payload.order.shipments.0.destination.lat' => 'nullable|string',
            'payload.order.shipments.0.destination.name' => 'nullable|string',
            'payload.order.shipments.0.destination.telephone' => 'nullable|string',
            'payload.order.shipments.0.destination.email' => 'nullable|string',

            'payload.details.goods_description' => 'required|string',
            'payload.details.country_of_origin' => 'required|string',
            'payload.order.purchases.*.dimensions.weight.value' => 'required|numeric',
            'payload.order.purchases.0.dimensions.weight.unit' => 'required|string',
            'payload.order.purchases.*.quantity' => 'required|numeric',
        ]);



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
                                "CompanyName" => "",
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
                        "ShippingDateTime" => Carbon::instance(now())->toIso8601String(),
                        "DueDate" => Carbon::instance(now()->addDay())->toIso8601String(),
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
                            "ProductGroup" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "EXP",
                            "ProductType" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "OND" : "PPX",
                            "PaymentType" => $this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "C" : "P",
                            "PaymentOptions" => $this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "ASCC" : "",
                            "CustomsValueAmount" => null,
                            "CashOnDeliveryAmount" => $this->attributes['payload']['order']['total']['amount'],
                            "InsuranceAmount" => null,
                            "CashAdditionalAmount" => null,
                            "CashAdditionalAmountDescription" => "",
                            "CollectAmount" => $this->attributes['payload']['order']['total'],
                            "Services" => $this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "CODS" : "",
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

            dispatch(new SendLabelJob($response->Shipments->ID, $this->user));

            $this->createPickup($response->Shipments->ID);

            return response('Message: your order is being processed , you’ll receive an email with the results.', 200);
        } catch (Exception $e) {
            response('Something went wrong please try again later!');
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
                                    "CompanyName" => "",
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
                                    "Value" => $this->weight,
                                ],
                                "ChargeableWeight" => null,
                                "DescriptionOfGoods" => $this->attributes['payload']['details']['goods_description'],
                                "GoodsOriginCountry" => $this->attributes['payload']['details']['country_of_origin'],
                                "NumberOfPieces" => $this->peices,
                                "ProductGroup" => $this->attributes['payload']['order']['shipments'][0]['destination']['country'] === $this->attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "EXP",
                                "ProductType" => "PDX",
                                "PaymentType" => $this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "C" : "P",
                                "PaymentOptions" => $this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "ASCC" : "",
                                "CustomsValueAmount" => null,
                                "CashOnDeliveryAmount" => $this->attributes['payload']['order']['total']['amount'],
                                "InsuranceAmount" => null,
                                "CashAdditionalAmount" => null,
                                "CashAdditionalAmountDescription" => "",
                                "CollectAmount" => $this->attributes['payload']['order']['total'],
                                "Services" => $this->attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "CODS" : "",
                                "Items" => []
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
