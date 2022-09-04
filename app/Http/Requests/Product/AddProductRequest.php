<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'shortname' => 'required|string|max:191',
            'biller_id' => 'required|integer|exists:billers,id',
            'description' => 'string|max:400',
            'product_code' => 'required|string|max:191',
            'logo' => 'string',
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'has_validation' => 'required|boolean',
            'enabled' => 'required|boolean',
            'service_status' => 'required|boolean',
            'deployed' => 'required|boolean',
            'min_amount' => 'required|numeric|between:0,9999999999.99|lte:max_amount',
            'max_amount' => 'required|numeric|between:0,9999999999.99|gte:min_amount',
            'max_quantity' => 'required|numeric|between:0,9999999999.99',

            'up_product_key' => 'required|string|max:191',
            'up_price' => 'required|numeric|between:0,9999999999.99',
            'vendor_code' => 'required|string|max:191',
            'has_sub_product' => 'required|boolean',

            'commission_type' => [
                'required',
                'string',
                'in:percentage,fixed',
            ],
            'provider_commission_value' => 'required|numeric|between:0,9999999999.99|lte:integrator_commission_value',
            'provider_commission_cap' => 'required|numeric|between:0,9999999999.99',
            'provider_commission_amount_cap' => 'required|numeric|between:0,9999999999.99',
            'integrator_commission_value' => 'required|numeric|between:0,9999999999.99',
            'integrator_commission_cap' => 'required|numeric|between:0,9999999999.99',
            'integrator_commission_amount_cap' => 'required|numeric|between:0,9999999999.99',
            'has_fee' => 'required|boolean',
            'fee_configuration' => 'array',
            'fee_configuration.type' =>  [
                'required_with:fee_configuration',
                'string',
                'in:percentage,fixed',
            ],
            'fee_configuration.value' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99',
            'fee_configuration.cap' => 'required_with:fee_configuration|numeric|between:0,9999999999.99',
            'fee_configuration.has_range' => 'required|boolean',
            'fee_configuration.range' => 'required_if:fee_configuration.has_range,true|array',
            'fee_configuration.range.*.min' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99|lte:fee_configuration.range.*.max',
            'fee_configuration.range.*.max' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99|gte:fee_configuration.range.*.min',
            'fee_configuration.range.*.value' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99',
            'type' => 'string|max:191'
        ];
    }
}
// [
//     'type' => $this->faker->randomElement(['fixed', 'percentage']),
//     'has_range' => $has_range,
//     'range' => $has_range ? [[
//         'min' => $this->faker->randomFloat(2, 0, 30),
//         'max' => $this->faker->randomFloat(2, 30, 100),
//         'value' => $this->faker->randomFloat(2, 0, 10),
//     ]] : null,
//     'cap' => $this->faker->randomFloat(2, 0, 100),
//     'value' => $this->faker->randomFloat(2, 0, 100),
// ]
