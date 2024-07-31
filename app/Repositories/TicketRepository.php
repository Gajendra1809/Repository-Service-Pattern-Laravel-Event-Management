<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository extends BaseRepository
{
    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function getTicketsByEvent($id){
        return $this->model->where('event_id', $id)->with('user')->get();
    }

    public function getTicketsByUser($id){
        return $this->model->where('user_id', $id)->with('event')->get();
    }

    public function getTicketByRazorpayId($id){
        return $this->model->where('razorpay_order_id', $id)->first();
    }

}
