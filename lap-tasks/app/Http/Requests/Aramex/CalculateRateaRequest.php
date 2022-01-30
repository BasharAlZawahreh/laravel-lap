<?php

namespace App\Http\Requests\Aramex;

use Illuminate\Foundation\Http\FormRequest;

class CalculateRateaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'meta.tenant.owner.email' => 'required|email',
            'payload.checkout.purchases.*.dimensions.weight.value' => 'required|numeric',
            'payload.checkout.purchases.*.attributes.0.value.en' => 'required|numeric',
            'payload.checkout.purchases.*.quantity' => 'required|numeric',
            'payload.checkout.shipping.destination.line1' => 'required|string|max:255',
            'payload.checkout.shipping.destination.line2' => 'nullable|string|max:255',
            'payload.checkout.shipping.destination.city' => 'required|string',
            'payload.checkout.shipping.destination.country' => 'required|string',
            'payload.checkout.shipping.destination.lng' => 'nullable|string',
            'payload.checkout.shipping.destination.lat' => 'nullable|string',
            'payload.checkout.shipping.destination.name' => 'nullable|string',
            'payload.checkout.shipping.destination.telephone' => 'nullable|string',
            'payload.checkout.shipping.source.line1' => 'required|string',
            'payload.checkout.shipping.source.line2' => 'nullable|string',
            'payload.checkout.shipping.source.city' => 'required|string',
            'payload.checkout.shipping.source.country' => 'required|string',
            'payload.checkout.shipping.source.lng' => 'nullable|string',
            'payload.checkout.shipping.source.lat' => 'nullable|string',
            'payload.checkout.shipping.source.name' => 'nullable|string',
            'payload.checkout.shipping.source.telephone' => 'nullable|string',
            'payload.rates.0.price.currency' => 'required|string',
            'payload.rates.0.name.en' => 'nullable|string',
        ];
    }
}
