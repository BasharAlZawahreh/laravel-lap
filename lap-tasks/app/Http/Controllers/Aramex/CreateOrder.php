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
    public function create()
    {
        $attributes = request()->validate([
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

        $weight = 0;
        $peices = 0;

        foreach ($attributes['payload']['order']['purchases'] as $item) {
            $weight += $item['dimensions']['weight']['value'] * $item['quantity'];
            $peices += $item['quantity'];
        }

        $this->user = User::where('email', $attributes['meta']['tenant']['owner']['email'])->first();
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
                                "Line1" => $attributes['payload']['order']['shipping_address']['line1'],
                                "Line2" => "",
                                "Line3" => "",
                                "City" => $attributes['payload']['order']['shipping_address']['city'],
                                "StateOrProvinceCode" => "",
                                "PostCode" => "",
                                "CountryCode" => $attributes['payload']['order']['shipping_address']['country'],
                                "Longitude" => $attributes['payload']['order']['shipments'][0]['source']['lng'] ?? 0,
                                "Latitude" =>  $attributes['payload']['order']['shipments'][0]['source']['lat'] ?? 0,
                                "BuildingNumber" => null,
                                "BuildingName" => null,
                                "Floor" => null,
                                "Apartment" => null,
                                "POBox" => null,
                                "Description" => null,
                            ],
                            "Contact" => [
                                "Department" => "",
                                "PersonName" => $attributes['payload']['order']['shipping_address']['name'],
                                "Title" => "",
                                "CompanyName" => $attributes['payload']['details']['company_name'],
                                "PhoneNumber1" => $attributes['payload']['order']['shipping_address']['telephone'],
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => $attributes['payload']['order']['shipping_address']['telephone'],
                                "EmailAddress" =>  $attributes['meta']['tenant']['owner']['email'],
                                "Type" => ""
                            ]
                        ],
                        "Consignee" => [
                            "Reference1" => "",
                            "Reference2" => "",
                            "AccountNumber" => "",
                            "PartyAddress" => [
                                "Line1" => $attributes['payload']['order']['shipments'][0]['destination']['line1'],
                                "Line2" => $attributes['payload']['order']['shipments'][0]['destination']['line2'],
                                "Line3" => "",
                                "City" => $attributes['payload']['order']['shipments'][0]['destination']['city'],
                                "StateOrProvinceCode" => "",
                                "PostCode" => "",
                                "CountryCode" => $attributes['payload']['order']['shipments'][0]['destination']['country'],
                                "Longitude" => $attributes['payload']['order']['shipments'][0]['destination']['lng'] ?? 0,
                                "Latitude" => $attributes['payload']['order']['shipments'][0]['destination']['lat'] ?? 0,
                                "BuildingNumber" => "",
                                "BuildingName" => "",
                                "Floor" => "",
                                "Apartment" => "",
                                "POBox" => null,
                                "Description" => ""
                            ],
                            "Contact" => [
                                "Department" => "",
                                "PersonName" => $attributes['payload']['order']['shipments'][0]['destination']['name'],
                                "Title" => "",
                                "CompanyName" => "",
                                "PhoneNumber1" => $attributes['payload']['order']['shipments'][0]['destination']['telephone'],
                                "PhoneNumber1Ext" => "",
                                "PhoneNumber2" => "",
                                "PhoneNumber2Ext" => "",
                                "FaxNumber" => "",
                                "CellPhone" => $attributes['payload']['order']['shipments'][0]['destination']['telephone'],
                                "EmailAddress" => $attributes['payload']['order']['shipments'][0]['destination']['email'],
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
                                "Value" => $weight,
                            ],
                            "ChargeableWeight" => null,
                            "DescriptionOfGoods" => $attributes['payload']['details']['goods_description'],
                            "GoodsOriginCountry" => $attributes['payload']['details']['country_of_origin'],
                            "NumberOfPieces" => $peices,
                            "ProductGroup" => $attributes['payload']['order']['shipments'][0]['destination']['country'] === $attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "EXP",
                            "ProductType" => "PDX",
                            "PaymentType" => $attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "C" : "P",
                            "PaymentOptions" => $attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "ASCC" : "",
                            "CustomsValueAmount" => null,
                            "CashOnDeliveryAmount" => $attributes['payload']['order']['total']['amount'],
                            "InsuranceAmount" => null,
                            "CashAdditionalAmount" => null,
                            "CashAdditionalAmountDescription" => "",
                            "CollectAmount" => $attributes['payload']['order']['total'],
                            "Services" => $attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "CODS" : "",
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

            return response('Message: your order is being processed , you’ll receive an email with the results.', 200);

        } catch (Exception $e) {
            throw new Exception('Not passed');
        }
    }
}
