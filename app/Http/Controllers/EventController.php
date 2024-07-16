<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EventService;
use App\Traits\JsonResponseTrait;

class EventController extends Controller
{
    use JsonResponseTrait;

    public $eventService;

    public function __construct(EventService $eventService){
        $this->eventService = $eventService;
        $this->middleware('checkrole')->only('store', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $events = $this->eventService->getEvents();
            return $this->successResponse($events, "Events retrieved successfully");

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function eventsByUser(Request $request)
    {
        try {

            $events = $this->eventService->getEventsByUser($request);
            return $this->successResponse($events, "Events retrieved successfully");

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

            $event = $this->eventService->create($request);
            return $this->successResponse($event, 'Event created successfully', 201);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $event = $this->eventService->getEventById($id);
            return $this->successResponse($event, "Event retrieved successfully");

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
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
        try {

            $event = $this->eventService->update($request, $id);
            return $this->successResponse($event, 'Event updated successfully', 201);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            if($this->eventService->delete($id)) {
                return $this->successResponse([], 'Event deleted successfully', 201);
            } else {
                return $this->errorResponse('Event not found', 404);
            }

        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
