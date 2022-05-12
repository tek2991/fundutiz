<?php

namespace App\Http\Resources\v1;

use App\Actions\Fundutiz\FundBalance;
use App\Models\FinancialYear;
use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->toDateString(),
            'current_balance' => FundBalance::current($this, auth()->user()->currentTeam, FinancialYear::current()),
        ];
    }
}
