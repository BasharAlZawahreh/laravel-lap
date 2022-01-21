<?php

namespace App\Models;

class CreateOrderRequestFromVetrina

{
    public function __invoke()
    {
        $jsonVertina = json_encode(
            array (
                'name' => 'confirm-order',
                'meta' =>
                array (
                  'tenant' =>
                  array (
                    'subscription' => 'active',
                    'name' => 'store-1rs7',
                    'country' => 'JO',
                    'store_host' => 'store-1rs7.staging4.shopgo.me',
                    'id' => '91060',
                    'timezone' => 'Asia/Amman',
                    'owner' =>
                    array (
                      'email' => 'aramex@poc.com',
                      'phone' => '+962786125854',
                      'created' => '2021-12-27T06:30:38.975051+00:00',
                      'permissions' =>
                      array (
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
                array (
                  'order' =>
                  array (
                    'total' =>
                    array (
                      'amount' => '109.00',
                      'currency' => 'JOD',
                    ),
                    'cancelled' => false,
                    'delivery_method' => 'store_delivery',
                    'created' => '2022-01-19T07:47:39.924925+00:00',
                    'payment_method' => 'cash_on_delivery',
                    'buyer' =>
                    array (
                      'ip' => '94.249.94.12',
                      'name' => 'sara samir',
                      'email' => NULL,
                      'phone' => '+962786125854',
                    ),
                    'number' => 'R3132645678',
                    'invoices' =>
                    array (
                    ),
                    'adjustments' =>
                    array (
                      0 =>
                      array (
                        'name' =>
                        array (
                          'en' => 'Economy Shipping (International)',
                          'ar' => 'Economy Shipping (International)',
                        ),
                        'kind' => 'shipping_charge',
                        'total' =>
                        array (
                          'amount' => '1.00',
                          'currency' => 'JOD',
                        ),
                      ),
                    ),
                    'custom_fields' =>
                    array (
                    ),
                    'visible' => true,
                    'authorized' => false,
                    'shipping_address' =>
                    array (
                      'line2' => NULL,
                      'telephone' => '+962786125854',
                      'lng' => NULL,
                      'name' => 'sara samir',
                      'line1' => 'line 1',
                      'country' => 'JO',
                      'city' => 'Amman',
                      'email' => NULL,
                      'lat' => NULL,
                      'postcode' => NULL,
                    ),
                    'viewed' => false,
                    'receipts' =>
                    array (
                      0 =>
                      array (
                        'receipt_url' =>
                        array (
                          'slip' =>
                          array (
                            'ar' => 'https://store-1rs7.staging4.shopgo.me/ar/order/R3132645678/order-slip/1tdvqthtqozikm0i',
                            'en' => 'https://store-1rs7.staging4.shopgo.me/order/R3132645678/order-slip/1tdvqthtqozikm0i',
                          ),
                        ),
                      ),
                    ),
                    'payments' =>
                    array (
                    ),
                    'billing_address' =>
                    array (
                      'line2' => NULL,
                      'telephone' => '+962786125854',
                      'lng' => NULL,
                      'name' => 'sara samir',
                      'line1' => 'line 1',
                      'country' => 'JO',
                      'city' => 'Amman',
                      'email' => NULL,
                      'lat' => NULL,
                      'postcode' => NULL,
                    ),
                    'confirmed' => true,
                    'purchases' =>
                    array (
                      0 =>
                      array (
                        'unit_price' =>
                        array (
                          'amount' => '24.00',
                          'currency' => 'JOD',
                        ),
                        'image' => 'https://staging-cdn.shopgo.me/demo/catalog/women/dress3/take1.jpg',
                        'name' =>
                        array (
                          'en' => 'Black Asymmetric Floral Dress',
                          'ar' => 'Black Asymmetric Floral Dress',
                        ),
                        'attributes' =>
                        array (
                          0 =>
                          array (
                            'name' =>
                            array (
                              'en' => 'الحجم',
                              'ar' => 'الحجم',
                            ),
                            'value' =>
                            array (
                              'en' => '8',
                              'ar' => '8',
                            ),
                          ),
                          1 =>
                          array (
                            'name' =>
                            array (
                              'en' => 'القالب',
                              'ar' => 'القالب',
                            ),
                            'value' =>
                            array (
                              'en' => 'نحيل',
                              'ar' => 'نحيل',
                            ),
                          ),
                        ),
                        'total' =>
                        array (
                          'amount' => '48.00',
                          'currency' => 'JOD',
                        ),
                        'dimensions' =>
                        array (
                          'width' =>
                          array (
                            'unit' => 'cm',
                            'value' => '30.00',
                          ),
                          'height' =>
                          array (
                            'unit' => 'cm',
                            'value' => '30.00',
                          ),
                          'length' =>
                          array (
                            'unit' => 'cm',
                            'value' => '30.00',
                          ),
                          'weight' =>
                          array (
                            'unit' => 'kg',
                            'value' => '0.30',
                          ),
                        ),
                        'charges' =>
                        array (
                        ),
                        'quantity' => 2,
                        'sku' => 'demo-dress-0003-00',
                      ),
                      1 =>
                      array (
                        'unit_price' =>
                        array (
                          'amount' => '20.00',
                          'currency' => 'JOD',
                        ),
                        'image' => 'https://staging-cdn.shopgo.me/demo/catalog/women/dress1/take1.jpg',
                        'name' =>
                        array (
                          'en' => 'Blue Floral Tie Front Dress',
                          'ar' => 'Blue Floral Tie Front Dress',
                        ),
                        'attributes' =>
                        array (
                          0 =>
                          array (
                            'name' =>
                            array (
                              'en' => 'الحجم',
                              'ar' => 'الحجم',
                            ),
                            'value' =>
                            array (
                              'en' => '8',
                              'ar' => '8',
                            ),
                          ),
                          1 =>
                          array (
                            'name' =>
                            array (
                              'en' => 'القالب',
                              'ar' => 'القالب',
                            ),
                            'value' =>
                            array (
                              'en' => 'نحيل',
                              'ar' => 'نحيل',
                            ),
                          ),
                        ),
                        'total' =>
                        array (
                          'amount' => '60.00',
                          'currency' => 'JOD',
                        ),
                        'dimensions' =>
                        array (
                          'width' =>
                          array (
                            'unit' => 'cm',
                            'value' => '150.00',
                          ),
                          'height' =>
                          array (
                            'unit' => 'cm',
                            'value' => '150.00',
                          ),
                          'length' =>
                          array (
                            'unit' => 'cm',
                            'value' => '150.00',
                          ),
                          'weight' =>
                          array (
                            'unit' => 'kg',
                            'value' => '0.50',
                          ),
                        ),
                        'charges' =>
                        array (
                        ),
                        'quantity' => 3,
                        'sku' => 'demo-dress-0001-00',
                      ),
                    ),
                    'source' => 'en',
                    'shipments' =>
                    array (
                      0 =>
                      array (
                        'state' => 'ready',
                        'target_delivery' => NULL,
                        'destination' =>
                        array (
                          'line2' => NULL,
                          'telephone' => '+962786125854',
                          'lng' => NULL,
                          'name' => 'sara samir',
                          'line1' => 'line 1',
                          'country' => 'JO',
                          'city' => 'Amman',
                          'email' => NULL,
                          'lat' => NULL,
                          'postcode' => NULL,
                        ),
                        'created' => '2022-01-19T07:47:42.553011+00:00',
                        'source' =>
                        array (
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
                        'provider' => 'matrix-rate',
                        'id' => '28947',
                        'tracking_id' => NULL,
                      ),
                    ),
                  ),
                  'details' =>
                  array (
                    'country_of_origin' => 'JO',
                    'goods_description' => 'miscellaneous',
                    'cellphone' => '+962786125854',
                    'company_name' => 'sara samir',
                  ),
                ),
              )

        );


        return response($jsonVertina, 200);
    }
}
