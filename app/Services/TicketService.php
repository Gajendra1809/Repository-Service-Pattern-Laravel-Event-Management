<?php

namespace App\Services;

use App\Repositories\TicketRepository;

class TicketService{

    public $ticketRepository;

    public function __construct(TicketRepository $ticketRepository){
        $this->ticketRepository = $ticketRepository;
    }

    public function getAll(){

        return $this->ticketRepository->all();

    }

    public function getTicketsByEvent($request){

        return $this->ticketRepository->getTicketsByEvent($request->id);

    }

    public function getTicketsByUser(){

        return $this->ticketRepository->getTicketsByUser(auth()->user()->id);

    }

    public function create($request){

        $data = $request->all();
        $data["user_id"]= auth()->user()->id;
        return $this->ticketRepository->create($data);

    }

}
