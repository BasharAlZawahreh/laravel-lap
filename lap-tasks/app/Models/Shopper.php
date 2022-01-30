<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopper extends Model
{
    use HasFactory;

    public static function getShopperAddress($attributes)
    {
        return [
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
        ];
    }
    public static function getShopperContact($attributes)
    {
        [
            "Department" => "",
            "PersonName" => $attributes['payload']['order']['shipments'][0]['destination']['name'],
            "Title" => "",
            "CompanyName" => $attributes['payload']['order']['shipments'][0]['destination']['name'],
            "PhoneNumber1" => $attributes['payload']['order']['shipments'][0]['destination']['telephone'],
            "PhoneNumber1Ext" => "",
            "PhoneNumber2" => "",
            "PhoneNumber2Ext" => "",
            "FaxNumber" => "",
            "CellPhone" => $attributes['payload']['order']['shipments'][0]['destination']['telephone'],
            "EmailAddress" => $attributes['payload']['order']['shipments'][0]['destination']['email'],
            "Type" => ""
        ];
    }
}
