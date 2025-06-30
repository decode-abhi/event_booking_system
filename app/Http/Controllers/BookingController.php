<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = auth()->user()->id;
        $bookings = Booking::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'data'=>$bookings,
            'message'=>'data is showing'
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->id(); // Authenticated user's ID

        // Validate input
        $validated = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'seat_booked' => 'required|integer|min:1',
        ]);

        // Get the event
        $event = Event::findOrFail($validated['event_id']);

        // Check if enough seats are available
        if ($event->available_seats < $validated['seat_booked']) {
            return response()->json([
                'message' => 'Not enough seats available. Only ' . $event->available_seats . ' left.',
            ], 400);
        }

        // Reduce the available seats
        $event->available_seats -= $validated['seat_booked'];
        $event->save();

        // Create the booking
        $booking = Booking::create([
            'user_id' => $user_id,
            'event_id' => $validated['event_id'],
            'seat_booked' => $validated['seat_booked'],
        ]);

        return response()->json([
            'message' => 'Booking successful.',
            'data' => $booking,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $bookings = Booking::findOrFail('id',$booking)->first();
        return response()->json([
            'data' => $bookings,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validation = $request->validate([
            'user_id' => 'required|integer',
            'event_id' => 'required|integer',
            'seat_booked' => 'required|integer',
        ]);
        $user_id = auth()->id;
        if($validation){
          
            $booking->update([
                'user_id' => $user_id,
                'event_id' => $request->event_id,
                'seat_booked' => $request->seat_booked,
            ]);

            return response()->json([
                'message' => 'data is stored',
            ]);
        }
        
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully.']);

    }
}
