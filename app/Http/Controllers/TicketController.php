<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Traits\JsonResponseTrait;

class TicketController extends Controller
{
    use JsonResponseTrait;

    public $ticketService;

    public function __construct(TicketService $ticketService){
        $this->ticketService = $ticketService;
    }
    
    /**
     * Display a listing of all tickets.
     */
    public function index()
    {
        try {

            $tickets = $this->ticketService->getAll();
            return $this->successResponse($tickets, "Tickets retrieved successfully");
            
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the tickets by event.
     */
    public function ticketsByEvent(Request $request)
    {
        try {

            $tickets = $this->ticketService->getTicketsByEvent($request);
            return $this->successResponse($tickets, "Tickets retrieved successfully");
            
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the tickets by user.
     */
    public function ticketsByUser()
    {
        try {

            $tickets = $this->ticketService->getTicketsByUser();
            return $this->successResponse($tickets, "Tickets retrieved successfully");
            
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            return $this->ticketService->create($request);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function paymentCallback(Request $request)
    {

        try {

            return $this->ticketService->paymentCallback($request);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
