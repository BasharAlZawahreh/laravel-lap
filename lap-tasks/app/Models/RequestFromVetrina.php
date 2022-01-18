<?php

namespace App\Models;

class RequestFromVetrina
{
    public function __invoke()
    {
        $jsonVertina = json_encode(
            array(
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
                            'email' => 'aramex@poc.com',
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
            )
        );


        return response($jsonVertina, 200);
    }
}
