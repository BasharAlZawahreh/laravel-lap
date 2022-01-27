<?php

namespace App\Http\Controllers\Aramex;

use App\Http\Controllers\Controller;
use App\Http\Requests\Aramex\CalculateRateaRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function PHPUnit\Framework\throwException;

class CalculateRate extends Controller
{
    /*
    protected $vetrinaRequest;
    public function __contsruct()
    {
        $vetrinaRequest = array(
            'name' => 'calculate-shipping-rates',
            'meta' =>
            array(
                'tenant' =>
                array(
                    'subscription' => 'active',
                    'name' => 'store-1rs7',
                    'country' => 'JO',
                    'store_host' => 'store-1rs7.staging4.shopgo.me',
                    'id' => '91060',
                    'timezone' => 'Asia/Amman',
                    'owner' =>
                    array(
                        'email' => 'reem@reem.com',
                        'phone' => '+962786125854',
                        'created' => '2021-12-27T06:30:38.975051+00:00',
                        'permissions' =>
                        array(
                            'home' => true,
                            'orders' => true,
                            'products' => true,
                            'settings' => true,
                            'customers' => true,
                            'analytics' => true,
                            'appearance' => true,
                            'branches' => true,
                        ),
                        'first_name' => 'aramex',
                        'last_name' => 'poc',
                        'id' => '81054',
                    ),
                ),
                'environment' => 'staging4',
            ),
            'payload' =>
            array(
                'rates' =>
                array(
                    0 =>
                    array(
                        'id' => 'matrix-rate-1',
                        'price' =>
                        array(
                            'amount' => 5,
                            'currency' => 'JOD',
                        ),
                        'duration' =>
                        array(
                            'value' => 1,
                            'unit' => 'days',
                        ),
                        'name' =>
                        array(
                            'en' => 'Jordan Local',
                            'ar' => 'الأردن (محلي)',
                        ),
                        'description' =>
                        array(
                            'en' => 'Delivers in 3 days',
                            'ar' => 'يتم التوصيل خلال 3 أيام',
                        ),
                        'provider' => 'matrix-rate',
                        'kind' => 'store_delivery',
                    ),
                    1 =>
                    array(
                        'id' => 'matrix-rate-2',
                        'price' =>
                        array(
                            'amount' => 1,
                            'currency' => 'JOD',
                        ),
                        'duration' =>
                        array(
                            'value' => 1,
                            'unit' => 'days',
                        ),
                        'name' =>
                        array(
                            'en' => 'Economy Shipping (International)',
                            'ar' => 'الشحن الإقتصادي (دولي)',
                        ),
                        'description' =>
                        array(
                            'en' => 'Delivers in 3 days',
                            'ar' => 'يتم التوصيل خلال 3 أيام',
                        ),
                        'provider' => 'matrix-rate',
                        'kind' => 'store_delivery',
                    ),
                ),
                'checkout' =>
                array(
                    'shipping' =>
                    array(
                        'source' =>
                        array(
                            'line2' => NULL,
                            'telephone' => '786125854',
                            'lng' => '35.91250621679689',
                            'name' => 'Aramex POC',
                            'line1' => 'line 1',
                            'country' => 'JO',
                            'city' => 'amman',
                            'email' => NULL,
                            'lat' => '31.94451475545495',
                            'postcode' => NULL,
                        ),
                        'destination' =>
                        array(
                            'line2' => NULL,
                            'telephone' => '+962786125854',
                            'lng' => NULL,
                            'name' => 'sara samir',
                            'line1' => 'line 1',
                            'country' => 'JO',
                            'city' => 'amman',
                            'email' => NULL,
                            'lat' => NULL,
                            'postcode' => NULL,
                        ),
                    ),
                    'purchases' =>
                    array(
                        0 =>
                        array(
                            'image' => NULL,
                            'name' =>
                            array(
                                'en' => 'Blue Floral Tie Front Dress',
                                'ar' => 'Blue Floral Tie Front Dress',
                            ),
                            'attributes' =>
                            array(
                                0 =>
                                array(
                                    'name' =>
                                    array(
                                        'en' => 'الحجم',
                                        'ar' => 'الحجم',
                                    ),
                                    'value' =>
                                    array(
                                        'en' => '8',
                                        'ar' => '8',
                                    ),
                                ),
                                1 =>
                                array(
                                    'name' =>
                                    array(
                                        'en' => 'القالب',
                                        'ar' => 'القالب',
                                    ),
                                    'value' =>
                                    array(
                                        'en' => 'نحيل',
                                        'ar' => 'نحيل',
                                    ),
                                ),
                            ),
                            'dimensions' =>
                            array(
                                'width' =>
                                array(
                                    'unit' => 'cm',
                                    'value' => '150.00',
                                ),
                                'height' =>
                                array(
                                    'unit' => 'cm',
                                    'value' => '150.00',
                                ),
                                'length' =>
                                array(
                                    'unit' => 'cm',
                                    'value' => '150.00',
                                ),
                                'weight' =>
                                array(
                                    'unit' => 'kg',
                                    'value' => '0.50',
                                ),
                            ),
                            'charges' =>
                            array(),
                            'quantity' => 2,
                            'sku' => 'demo-dress-0001-00',
                        ),
                        1 =>
                        array(
                            'image' => NULL,
                            'name' =>
                            array(
                                'en' => 'Black Asymmetric Floral Dress',
                                'ar' => 'Black Asymmetric Floral Dress',
                            ),
                            'attributes' =>
                            array(
                                0 =>
                                array(
                                    'name' =>
                                    array(
                                        'en' => 'الحجم',
                                        'ar' => 'الحجم',
                                    ),
                                    'value' =>
                                    array(
                                        'en' => '8',
                                        'ar' => '8',
                                    ),
                                ),
                                1 =>
                                array(
                                    'name' =>
                                    array(
                                        'en' => 'القالب',
                                        'ar' => 'القالب',
                                    ),
                                    'value' =>
                                    array(
                                        'en' => 'نحيل',
                                        'ar' => 'نحيل',
                                    ),
                                ),
                            ),
                            'dimensions' =>
                            array(
                                'width' =>
                                array(
                                    'unit' => 'cm',
                                    'value' => '30.00',
                                ),
                                'height' =>
                                array(
                                    'unit' => 'cm',
                                    'value' => '30.00',
                                ),
                                'length' =>
                                array(
                                    'unit' => 'cm',
                                    'value' => '30.00',
                                ),
                                'weight' =>
                                array(
                                    'unit' => 'kg',
                                    'value' => '0.30',
                                ),
                            ),
                            'charges' =>
                            array(),
                            'quantity' => 1,
                            'sku' => 'demo-dress-0003-00',
                        ),
                    ),
                ),
            ),
        );
    }
    */

    public function calculate(CalculateRateaRequest $request)
    {

        $attributes = $request->validated();


        $user = User::where('email', $attributes['meta']['tenant']['owner']['email'])->first();
        if (!$user) {
            return response('User Not Found', 404);
        }

        $weight = 0;
        $price = 0;
        $peices = 0;

        foreach ($attributes['payload']['checkout']['purchases'] as $item) {
            $weight += $item['dimensions']['weight']['value'] * $item['quantity'];
            $price += $item['attributes'][0]['value']['en'] * $item['quantity'];
            $peices += $item['quantity'];
        }


        $response = Http::post('https://ws.dev.aramex.net/ShippingAPI.V2/RateCalculator/Service_1_0.svc/json/CalculateRate', [
            "ClientInfo" => [
                "UserName" => $user->email,
                "Password" => $user->password,
                "Version" => $user->version,
                "AccountNumber" => $user->accountNumber,
                "AccountPin" => $user->accountPin,
                "AccountEntity" => $user->accountEntity,
                "AccountCountryCode" => $user->accountCountryCode,
                "Source" => $user->source
            ],
            "DestinationAddress" => [
                "Line1" => $attributes['payload']['checkout']['shipping']['destination']['line1'],
                "Line2" => $attributes['payload']['checkout']['shipping']['destination']['line2'],
                "Line3" => "",
                "City" =>  ucwords($attributes['payload']['checkout']['shipping']['destination']['city']),
                "StateOrProvinceCode" => "",
                "PostCode" => "",
                "CountryCode" => $attributes['payload']['checkout']['shipping']['destination']['country'],
                "Longitude" => $attributes['payload']['checkout']['shipping']['destination']['lng'] ?? 0,
                "Latitude" => $attributes['payload']['checkout']['shipping']['destination']['lat'] ?? 0,
                "BuildingNumber" => null,
                "BuildingName" => null,
                "Floor" => null,
                "Apartment" => null,
                "POBox" => null,
                "Description" => $attributes['payload']['checkout']['shipping']['destination']['name'] . '  ' . $attributes['payload']['checkout']['shipping']['destination']['telephone'],
            ],
            "OriginAddress" => [
                "Line1" => $attributes['payload']['checkout']['shipping']['source']['line1'],
                "Line2" => $attributes['payload']['checkout']['shipping']['source']['line2'],
                "Line3" => "",
                "City" =>  ucwords($attributes['payload']['checkout']['shipping']['source']['city']),
                "StateOrProvinceCode" => "",
                "PostCode" => "",
                "CountryCode" => $attributes['payload']['checkout']['shipping']['source']['country'],
                "Longitude" => $attributes['payload']['checkout']['shipping']['source']['lng'] ?? 0,
                "Latitude" => $attributes['payload']['checkout']['shipping']['source']['lat'] ?? 0,
                "BuildingNumber" => null,
                "BuildingName" => null,
                "Floor" => null,
                "Apartment" => null,
                "POBox" => null,
                "Description" => $attributes['payload']['checkout']['shipping']['source']['name'] . '  ' . $attributes['payload']['checkout']['shipping']['source']['telephone']
            ],
            "PreferredCurrencyCode" => $attributes['payload']['rates'][0]['price']['currency'],
            "ShipmentDetails" => [
                "Dimensions" => null,
                "ActualWeight" => [
                    "Unit" => "KG",
                    "Value" => $weight
                ],
                "ChargeableWeight" => null,
                "DescriptionOfGoods" => null,
                "GoodsOriginCountry" => null,
                "NumberOfPieces" => $peices,
                "ProductGroup" => $attributes['payload']['rates'][0]['name']['en'] === "Jordan Local" ? "DOM" : "EXP",
                "ProductType" => $attributes['payload']['rates'][0]['name']['en'] === "Jordan Local" ? "OND" : "PPX",
                "PaymentType" => "P",
                "PaymentOptions" => "",
                "CustomsValueAmount" => null,
                "CashOnDeliveryAmount" => null,
                "InsuranceAmount" => null,
                "CashAdditionalAmount" => null,
                "CashAdditionalAmountDescription" => null,
                "CollectAmount" => null,
                "Services" => "",
                "Items" => null,
                "DeliveryInstructions" => null
            ],
            "Transaction" => [
                "Reference1" => "",
                "Reference2" => "",
                "Reference3" => "",
                "Reference4" => "",
                "Reference5" => ""
            ]
        ]);

        return response($response, 200);
    }
}
