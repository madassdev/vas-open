<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromQuery, WithHeadings, WithMapping
{
    private $query;
    use Exportable;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function headings(): array
    {
        return [
            'id',
            'business_id',
            'business_name',
            'product_id',
            'product_name',
            'product_category_name',
            'amount',
            'integrator_debited_amount',
            'provider_debited_amount',
            'idempotency_hash',
            'business_reference',
            'debit_reference',
            'transaction_reference',
            'provider_reference',
            'debited_amount',
            'product_price',
            'fee',
            'integrator_commission',
            'owner_commission',
            'account_number',
            'phone_number',
            'value_given',
            'transaction_status',
            'payment_status',
            'status_code',
            'status_message',
            'provider_message',
            'retries',
            'narration',
            'created_at',
            'updated_at',
        ];
    }

    public function query()
    {
        return $this->query;
    }

    public function map($t): array
    {
        return [
            $t->id,
            $t->business_id,
            $t->business->name,
            $t->product_id,
            $t->product->name,
            $t->product->productCategory->name,
            $t->amount,
            $t->integrator_debited_amount,
            $t->provider_debited_amount,
            $t->idempotency_hash,
            $t->business_reference,
            $t->debit_reference,
            $t->transaction_reference,
            $t->provider_reference,
            $t->debited_amount,
            $t->product_price,
            $t->fee,
            $t->integrator_commission,
            $t->owner_commission,
            $t->account_number,
            $t->phone_number,
            $t->value_given,
            $t->transaction_status,
            $t->payment_status,
            $t->status_code,
            $t->status_message,
            $t->provider_message,
            $t->retries,
            $t->narration,
            $t->created_at,
            $t->updated_at,
        ];
    }
}
