<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
        $title = '';
        if($this->type == 1) {
            $type = '+';
            $title = 'From - ' . ($this->source ? $this->source->name : '');
        } else if($this->type == 2) {
            $type = '-';
            $title = 'To - ' . ($this->source ? $this->source->name : '');
        }

        return [
            'trx_id' => $this->trx_id,
            'amount' => $type . number_format($this->amount, 2) . ' MMK',
            'source' => $title,
            'type' => $this->type, // 1 => income, 2 => expense
            'date_time' =>  Carbon::parse($this->created_at)->diffForHumans(). ' - ' .
                            Carbon::parse($this->created_at)->toFormattedDateString(). ' - ' . Carbon::parse($this->created_at)->format('h:i:s A'),
        ];
    }
}
