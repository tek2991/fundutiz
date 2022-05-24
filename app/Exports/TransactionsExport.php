<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{

    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  collect($this->transactions);
    }

    public function headings(): array
    {
        return [
            'tnx_id',
            'fund',
            'team',
            'type',
            'status',
            'sanctioned_at',
            'amount',
            'item',
            'vendor_name',
            'file_number',
            'is_gem',
            'non_gem_remark',
            'gem_non_availability',
            'gem_non_availability_remark',
            'sanctioner',
            'financial_year',
            'last_updated_by',
            'last_updated_at',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->fund->name,
            $transaction->team->name,
            $transaction->type,
            $transaction->status,
            $transaction->sanctioned_at->format('d/m/Y'),
            $transaction->amount,
            $transaction->item,
            $transaction->vendor_name,
            $transaction->file_number,
            $transaction->is_gem ? 'Yes' : 'No',
            $transaction->non_gem_remark,
            $transaction->gem_non_availability ? 'Yes' : 'No',
            $transaction->gem_non_availability_remark,
            $transaction->sanctioner->name,
            $transaction->financialYear->name,
            $transaction->lastUser->name,
            $transaction->updated_at->format('d/m/Y'),
        ];
    }
}
