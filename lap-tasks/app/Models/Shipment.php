<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;


    private static function getWeight($attributes)
    {
        $weight = 0;
        foreach ($attributes['payload']['order']['purchases'] as $item) {
            $weight += $item['dimensions']['weight']['value'] * $item['quantity'];
        }

        return $weight;
    }

    private static function getPeices($attributes)
    {
        $peices = 0;
        foreach ($attributes['payload']['order']['purchases'] as $item) {
            $peices += $item['quantity'];
        }

        return $peices;
    }


    public static function getShipmentDetails($attributes)
    {

        return  [
            "Dimensions" => null,
            "ActualWeight" => [
                "Unit" => "KG",
                "Value" => Shipment::getWeight($attributes),
            ],
            "ChargeableWeight" => null,
            "DescriptionOfGoods" => $attributes['payload']['details']['goods_description'],
            "GoodsOriginCountry" => $attributes['payload']['details']['country_of_origin'],
            "NumberOfPieces" => Shipment::getPeices($attributes),
            "ProductGroup" => $attributes['payload']['order']['shipments'][0]['destination']['country'] === $attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "DOM",
            "ProductType" => $attributes['payload']['order']['shipments'][0]['destination']['country'] === $attributes['payload']['order']['shipping_address']['country'] ? "OND" : "OND",
            "PaymentType" => "P", #$attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "C" : "P",
            "PaymentOptions" => "", #$attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "ASCC" : "",
            "CustomsValueAmount" => null,
            "CashOnDeliveryAmount" => null, #$attributes['payload']['order']['total']['amount'],
            "InsuranceAmount" => null,
            "CashAdditionalAmount" => null,
            "CashAdditionalAmountDescription" => "Please ss",
            "CollectAmount" => null,
            "Services" => "", #$attributes['payload']['order']['payment_method'] === 'cash_on_delivery' ? "CODS" : "",
            "Items" => []
        ];
    }

    public static function getPickupItems($attributes)
    {
        return [
            "ProductGroup" =>  $attributes['payload']['order']['shipments'][0]['destination']['country'] === $attributes['payload']['order']['shipping_address']['country'] ? "DOM" : "DOM",
            "ProductType" => "OND",
            "NumberOfShipments" => Shipment::getPeices($attributes),
            "PackageType" => "Box",
            "Payment" => "P",
            "ShipmentWeight" => [
                "Unit" => "KG",
                "Value" => Shipment::getWeight($attributes),
            ],
            "ShipmentVolume" => null,
            "NumberOfPieces" => Shipment::getPeices($attributes),
            "CashAmount" => null,
            "ExtraCharges" => null,
            "ShipmentDimensions" => [
                "Length" => 0,
                "Width" => 0,
                "Height" => 0,
                "Unit" => "CM"
            ],
            "Comments" => "Test"
        ];
    }
}
