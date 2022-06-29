<?php

namespace App\Imports;

use App\Models\FinancialYear;

use Illuminate\Support\Carbon;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransactionsImport implements ToCollection, WithHeadingRow, WithValidation
{
    use Importable;


    public function rules(): array
    {
        return [
            '*.oa_name' => 'required|string',
            '*.sanction_date' => 'required|date',
            '*.amount' => 'required|numeric',
            '*.head_of_account' => 'required|string',
            '*.file_number' => 'required|string',
            '*.details_of_expenditure' => 'required|string',
            '*.remarks' => 'required|string',
            '*.sanctioned_by' => 'required|string',
            '*.item' => 'required|string',
            '*.vendor_name' => 'required|string',
            '*.in_gem' => 'required|string',
            '*.email' => 'required|email',
        ];
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            $fund_id = DB::table('funds')->where('name', $row['head_of_account'])->value('id');
            $team_id = DB::table('teams')->where('name', 'Tech Section')->value('id');
            $type = 'utilization';
            $status = 'incured';
            $sanctioned_date = Carbon::createFromFormat('d-m-Y', $row['sanction_date'])->format('Y-m-d');
            $is_gem = $row['in_gem'] == 'GeM' ? true : false;
            $gem_non_availability = $row['in_gem'] == 'Service/Product Not available in GeM' ? true : false;
            $gem_non_availability_remark = $gem_non_availability ? 'Service/Product Not available in GeM' : null;
            $non_gem_remark = $is_gem == false && $gem_non_availability == false ? 'Non GeM' : null;
            $sanctioner_id = DB::table('sanctioners')->where('name', $row['sanctioned_by'])->value('id');
            $user_id = DB::table('users')->where('email', $row['email'])->value('id');
            $oa_name = $row['oa_name'];
            $financialYearId = FinancialYear::current()->id;

             
            DB::table('transactions')->insert([
                'fund_id' => $fund_id,
                'team_id' => $team_id,
                'type' => $type,
                'status' => $status,
                'sanctioned_at' => $sanctioned_date,
                'amount_in_cents' => $row['amount']*100,
                'item' => $row['item'],
                'vendor_name' => $row['vendor_name'],
                'file_number' => $row['file_number'],
                'is_gem' => $is_gem,
                'gem_non_availability' => $gem_non_availability,
                'gem_non_availability_remark' => $gem_non_availability_remark,
                'non_gem_remark' => $non_gem_remark,
                'sanctioner_id' => $sanctioner_id,
                'user_id' => $user_id,
                'financial_year_id' => $financialYearId,
                'created_at' => now(),
                'updated_at' => now(),
                'oa_name' => $oa_name,
            ]);
        }
    }
}
