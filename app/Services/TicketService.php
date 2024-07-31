<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Repositories\EventRepository;
use Razorpay\Api\Api;

class TicketService{

    public $ticketRepository;
    public $eventRepository;

    public function __construct(TicketRepository $ticketRepository, EventRepository $eventRepository){
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
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

        $event = $this->eventRepository->find($request->event_id);
            $user = auth()->user();

            $api = new Api("rzp_test_Y3BabS2kuePGlC", "YYX7Ej8EkGyutrrOCaWtrETV");

            $order = $api->order->create([
                'receipt' => 'order_rcptid_' . $event->id,
                'amount' => $event->price * 100, // Amount in paisa
                'currency' => 'INR',
            ]);

            $ticket = $this->ticketRepository->create([
                'event_id' => $event->id,
                'amount' => $event->price,
                'user_id' => $user->id,
                'status' => 'pending',
                'razorpay_order_id' => $order->id,
            ]);

            return response()->json([
                'order_id' => $order->id,
                'ticket' => $ticket,
                'event' => $event,
                'user' => $user
            ]);

    }

    public function paymentCallback($request){

        $api = new Api("rzp_test_Y3BabS2kuePGlC", "YYX7Ej8EkGyutrrOCaWtrETV");

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];

        $ticket = $this->ticketRepository->getTicketByRazorpayId($request->razorpay_order_id);

        try {
            $api->utility->verifyPaymentSignature($attributes);

            $this->ticketRepository->update($ticket->id,[
                'status' => 'confirmed',
            ]);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Payment successful',
                    'ticket' => $ticket
                ],
                200
            );
        } catch (\Exception $e) {
            $this->ticketRepository->update($ticket->id,[
                'status' => 'confirmed',
            ]);

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Payment failed',
                    'ticket' => $ticket
                ],
                400
            );
        }

    }

}
