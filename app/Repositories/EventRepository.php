<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository extends BaseRepository
{
    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function getEventsByUser($id){
        return $this->model->where('user_id', $id)->with('tickets')->get();
    }

}
