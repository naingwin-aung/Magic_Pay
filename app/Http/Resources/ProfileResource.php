<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $unread_noti_count = $this->unreadNotifications()->count();

        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'amount' => $this->wallet ? number_format($this->wallet->amount, 2) . ' MMK' : '',
            'account_number' => $this->wallet ? $this->wallet->account_number : '',
            'unread_noti_count' => $unread_noti_count,
            'profile' => asset('frontend/img/profile.png'),
            'receive_qr_value' => $this->phone,
        ];
    }
}
