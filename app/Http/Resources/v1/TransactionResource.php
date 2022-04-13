<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            // 'fund_id' => $this->fund_id,
            // 'team_id' => $this->team_id,
            'type' => $this->type,
            'status' => $this->status,
            'sanctioned_at' => $this->sanctioned_at->toDateString(),
            'amount' => $this->amount,
            'item' => $this->item,
            'vendor_name' => $this->vendor_name,
            'file_number' => $this->file_number,
            'is_gem' => $this->is_gem,
            'non_gem_remark' => $this->non_gem_remark,
            'gem_non_availability' => $this->gem_non_availability,
            'gem_non_availability_remark' => $this->gem_non_availability_remark,
            // 'sanctioner_id' => $this->sanctioner_id,
            // 'user_id' => $this->user_id,
            // 'financial_year_id' => $this->financial_year_id,
        ];
    }
}
