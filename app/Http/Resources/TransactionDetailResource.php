<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $type = '';
        if($this->type == 1) {
            $type = "+";
        } else if($this->type == 2) {
            $type = "-";
        }

        return [
            'trx_id' => $this->trx_id,
            'ref_no' => $this->ref_no,
            'type' => $this->type, //1 => income, 2 => expense
            'amount' => $type . number_format($this->amount, 2) . ' MMK',
            'date_time' => Carbon::parse($this->created_at)->toFormattedDateString(). ' - ' . Carbon::parse($this->created_at)->format('h:i:s A'),
            'source_name' => $this->source ? $this->source->name : '',
            'source_phone' => $this->source ? $this->source->phone : '',
            'description' => $this->description
        ];
    }
}
