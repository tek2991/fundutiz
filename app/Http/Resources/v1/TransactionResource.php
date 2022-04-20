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
            'fund' => new FundResource($this->fund),
            'team' => new TeamResource($this->team),
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
            'sanctioner' => new SanctionerResource($this->sanctioner),
            'user' => new UserResource($this->lastUser),
            'financialYear' => new FinancialYearResource($this->financialYear),
        ];
    }
}
