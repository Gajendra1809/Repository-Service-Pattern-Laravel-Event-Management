<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService {

    public $eventRepository;

    public function __construct(EventRepository $eventRepository){
        $this->eventRepository = $eventRepository;
    }

    public function getEvents(){

        return $this->eventRepository->all();

    }

    public function getEventsByUser($request){

        return $this->eventRepository->getEventsByUser($request->id);

    }

    public function getEventById($id){
        
        return $this->eventRepository->find($id);
        
    }

    public function create($request){

        $data = $request->all();
        $data['user_id']= auth()->user()->id;
        return $this->eventRepository->create($data);

    }

    public function update($request, $id){

        $data = $request->all();
        return $this->eventRepository->update($id, $data);

    }

    public function delete($id){

        return $this->eventRepository->delete($id);

    }

}
