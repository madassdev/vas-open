<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'string|max:191',
            'unit_cost' => 'numeric|between:0,9999999999.99',
            'shortname' => 'string|max:191',
            'biller_id' => 'integer|exists:billers,id',
            'description' => 'max:400',
            'product_code' => 'string|max:191',
            'logo' => 'string',
            'product_category_id' => 'integer|exists:product_categories,id',
            'has_validation' => 'boolean',
            'enabled' => 'boolean',
            'service_status' => 'boolean',
            'deployed' => 'boolean',
            'min_amount' => 'numeric|between:0,9999999999.99|lte:max_amount',
            'max_amount' => 'numeric|between:0,9999999999.99|gte:min_amount',
            'max_quantity' => 'numeric|between:0,9999999999.99',
            'commission_type' => [
                'string',
                'in:percentage,fixed',
            ],
            'provider_commission_value' => 'numeric|between:0,9999999999.99|lte:integrator_commission_value',
            'provider_commission_cap' => 'numeric|between:0,9999999999.99',
            'provider_commission_amount_cap' => 'numeric|between:0,9999999999.99',
            'integrator_commission_value' => 'numeric|between:0,9999999999.99',
            'integrator_commission_cap' => 'numeric|between:0,9999999999.99',
            'integrator_commission_amount_cap' => 'numeric|between:0,9999999999.99',
            'has_fee' => 'boolean',
            'fee_configuration' => 'array',
            'fee_configuration.type' =>  [
                'required_with:fee_configuration',
                'string',
                'in:percentage,fixed',
            ],
            'fee_configuration.value' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99',
            'fee_configuration.cap' => 'required_with:fee_configuration|numeric|between:0,9999999999.99',
            'fee_configuration.has_range' => 'boolean',
            'fee_configuration.range' => 'required_if:fee_configuration.has_range,true|array',
            'fee_configuration.range.*.min' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99|lte:fee_configuration.range.*.max',
            'fee_configuration.range.*.max' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99|gte:fee_configuration.range.*.min',
            'fee_configuration.range.*.value' => 'required_if:fee_configuration.has_range,true|numeric|between:0,9999999999.99',
            'type' => 'string|max:191'

        ];
    }
}
