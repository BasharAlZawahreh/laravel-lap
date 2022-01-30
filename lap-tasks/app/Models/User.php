<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public static function getUserInfo($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return [
            "UserName" => $user->email,
            "Password" => $user->password,
            "Version" => $user->version,
            "AccountNumber" => $user->accountNumber,
            "AccountPin" => $user->accountPin,
            "AccountEntity" => $user->accountEntity,
            "AccountCountryCode" => $user->accountCountryCode,
            "Source" => $user->source
        ];
    }

    public static function getShopAddress($attributes)
    {
        return [
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
        ];
    }

    public static function getShopContact($attributes)
    {
        return [
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
        ];
    }
}
